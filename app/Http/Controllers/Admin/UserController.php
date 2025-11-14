<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\KaryawanController;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->when($role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.index', compact('users', 'search', 'role'));
    }

    public function create()
    {
        // Ambil karyawan yang belum memiliki user_id
        $karyawanList = Karyawan::whereNull('user_id')
            ->orWhere('user_id', 0)
            ->with('jabatan')
            ->orderBy('nama', 'asc')
            ->get();

        return view('admin.users.create', compact('karyawanList'));
    }

    public function store(Request $request)
    {
        // Validasi dasar
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', Rule::in(['admin', 'manager', 'karyawan'])],
            'foto' => ['nullable', 'image', 'max:2048'],
        ];

        // Jika role karyawan ATAU manager, karyawan_id wajib diisi
        if ($request->role === 'karyawan' || $request->role === 'manager') {
            $rules['karyawan_id'] = ['required', 'exists:karyawan,id_karyawan'];
        }

        $request->validate($rules);

        // Validasi tambahan: cek apakah karyawan sudah memiliki user
        if (($request->role === 'karyawan' || $request->role === 'manager') && $request->filled('karyawan_id')) {
            $karyawan = Karyawan::find($request->karyawan_id);

            if (!$karyawan) {
                return back()->withInput()->withErrors([
                    'karyawan_id' => 'Karyawan tidak ditemukan.'
                ]);
            }

            if ($karyawan->user_id && $karyawan->user_id > 0) {
                return back()->withInput()->withErrors([
                    'karyawan_id' => 'Karyawan yang dipilih sudah memiliki akun user. Silakan pilih karyawan lain.'
                ]);
            }
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ];

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('uploads/user', 'public');
            $userData['foto'] = $fotoPath;
        }

        // Buat user
        $user = User::create($userData);

        // Jika role karyawan atau manager, update karyawan dengan user_id
        if (($request->role === 'karyawan' || $request->role === 'manager') && $request->filled('karyawan_id')) {
            Karyawan::where('id_karyawan', $request->karyawan_id)
                ->update(['user_id' => $user->id]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::with('karyawan')->findOrFail($id);

        // Ambil karyawan yang belum punya user ATAU karyawan yang sedang di-edit ini
        $karyawanList = Karyawan::where(function ($query) use ($user) {
            $query->whereNull('user_id')
                ->orWhere('user_id', 0)
                ->orWhere('user_id', $user->id);
        })
            ->with('jabatan')
            ->orderBy('nama', 'asc')
            ->get();

        return view('admin.users.edit', compact('user', 'karyawanList'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi dasar
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', Rule::in(['admin', 'manager', 'karyawan'])],
            'foto' => ['nullable', 'image', 'max:2048'],
        ];

        // Jika role karyawan ATAU manager, karyawan_id wajib diisi
        if ($request->role === 'karyawan' || $request->role === 'manager') {
            $rules['karyawan_id'] = ['required', 'exists:karyawan,id_karyawan'];
        }

        $request->validate($rules);

        // Validasi tambahan: cek apakah karyawan sudah memiliki user lain
        if (($request->role === 'karyawan' || $request->role === 'manager') && $request->filled('karyawan_id')) {
            $karyawan = Karyawan::find($request->karyawan_id);

            if (!$karyawan) {
                return back()->withInput()->withErrors([
                    'karyawan_id' => 'Karyawan tidak ditemukan.'
                ]);
            }

            // Cek jika karyawan sudah punya user lain (bukan user yang sedang diedit)
            if ($karyawan->user_id && $karyawan->user_id > 0 && $karyawan->user_id != $user->id) {
                return back()->withInput()->withErrors([
                    'karyawan_id' => 'Karyawan yang dipilih sudah memiliki akun user lain. Silakan pilih karyawan lain.'
                ]);
            }
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Update password jika diisi
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $fotoPath = $request->file('foto')->store('uploads/user', 'public');
            $userData['foto'] = $fotoPath;
        }

        // Handle perubahan karyawan relation
        $oldKaryawan = $user->karyawan;

        if (($request->role === 'karyawan' || $request->role === 'manager') && $request->filled('karyawan_id')) {
            // Jika user sudah punya karyawan sebelumnya dan berbeda, lepas hubungan lama
            if ($oldKaryawan && $oldKaryawan->id_karyawan != $request->karyawan_id) {
                Karyawan::where('id_karyawan', $oldKaryawan->id_karyawan)
                    ->update(['user_id' => null]);
            }

            // Set hubungan baru
            Karyawan::where('id_karyawan', $request->karyawan_id)
                ->update(['user_id' => $user->id]);
        } else {
            // Jika role bukan karyawan/manager, lepas semua hubungan
            if ($oldKaryawan) {
                Karyawan::where('id_karyawan', $oldKaryawan->id_karyawan)
                    ->update(['user_id' => null]);
            }
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Cek jika user sedang digunakan di tabel karyawan
        if ($user->karyawan) {
            // Lepas hubungan dulu sebelum hapus (atau bisa langsung tolak)
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus user karena masih terhubung dengan data karyawan: ' . $user->karyawan->nama . '. Lepaskan hubungan karyawan terlebih dahulu.');
        }

        // Cek jika user adalah admin terakhir
        if ($user->role === 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Tidak dapat menghapus admin terakhir dalam sistem.');
            }
        }

        // Hapus foto jika ada
        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
