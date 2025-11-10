<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\Rating;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'manager']);
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

        return view('manager.karyawan.index', compact('karyawans', 'search', 'jabatans', 'ratings', 'filterJabatan', 'filterRating'));
    }

    public function show($id)
    {
        $karyawan = Karyawan::with(['jabatan', 'rating'])->findOrFail($id);
        return view('manager.karyawan.show', compact('karyawan'));
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $ratings = Rating::all();
        return view('manager.karyawan.edit', compact('karyawan', 'ratings'));
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $validated = $request->validate([
            'id_rating' => 'required|exists:rating,id_rating',
        ]);

        $karyawan->update($validated);

        return redirect()->route('manager.karyawan.index')->with('success', 'Rating karyawan berhasil diperbarui');
    }
}
