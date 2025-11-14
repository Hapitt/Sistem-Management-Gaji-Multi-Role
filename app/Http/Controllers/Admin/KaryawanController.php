<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $filterJabatan = $request->input('jabatan');
        $filterRating = $request->input('rating');

        $jabatans = Jabatan::all();
        $ratings = Rating::all();

        $karyawans = Karyawan::with(['jabatan', 'rating'])
            ->when($search, fn($q) => $q->where('nama', 'like', "%{$search}%")
                ->orWhere('divisi', 'like', "%{$search}%")
                ->orWhere('alamat', 'like', "%{$search}%"))
            ->when($filterJabatan, fn($q) => $q->where('id_jabatan', $filterJabatan))
            ->when($filterRating, fn($q) => $q->where('id_rating', $filterRating))
            ->orderBy('id_karyawan', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.karyawan.index', compact('karyawans', 'search', 'jabatans', 'ratings', 'filterJabatan', 'filterRating'));
    }

    public function create()
    {
        $jabatans = Jabatan::all();
        $ratings = Rating::all();
        return view('admin.karyawan.create', compact('jabatans', 'ratings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'id_rating' => 'required|exists:rating,id_rating',
            'nama' => 'required|string|max:255',
            'divisi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'umur' => 'required|integer',
            'jenis_kelamin' => 'required|string',
            'status' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('uploads/karyawan', 'public');
        }

        
        if (!empty($validated['user_id'])) {
            $exists = Karyawan::where('user_id', $validated['user_id'])->exists();
            if ($exists) {
                return back()->withInput()->withErrors(['user_id' => 'User sudah terhubung ke karyawan lain.']);
            }
        }

        Karyawan::create($validated);

        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function show($id)
    {
        $karyawan = Karyawan::with(['jabatan', 'rating'])->findOrFail($id);
        return view('admin.karyawan.show', compact('karyawan'));
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $jabatans = Jabatan::all();
        $ratings = Rating::all();
        return view('admin.karyawan.edit', compact('karyawan', 'jabatans', 'ratings'));
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'id_rating' => 'required|exists:rating,id_rating',
            'nama' => 'required|string|max:255',
            'divisi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'umur' => 'required|integer',
            'jenis_kelamin' => 'required|string',
            'status' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($karyawan->foto && Storage::disk('public')->exists($karyawan->foto)) {
                Storage::disk('public')->delete($karyawan->foto);
            }
            $validated['foto'] = $request->file('foto')->store('uploads/karyawan', 'public');
        }

        if (!empty($validated['user_id'])) {
            $exists = Karyawan::where('user_id', $validated['user_id'])->where('id_karyawan', '!=', $id)->exists();
            if ($exists) {
                return back()->withInput()->withErrors(['user_id' => 'User sudah terhubung ke karyawan lain.']);
            }
        }

        $karyawan->update($validated);

        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        if ($karyawan->foto && Storage::disk('public')->exists($karyawan->foto)) {
            Storage::disk('public')->delete($karyawan->foto);
        }

        $karyawan->delete();

        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil dihapus');
    }
}
