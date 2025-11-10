<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\Rating;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'karyawan']);
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
            ->where('status', 'Aktif') // Hanya menampilkan karyawan aktif
            ->orderBy('nama', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('karyawan.karyawan.index', compact('karyawans', 'search', 'jabatans', 'ratings', 'filterJabatan', 'filterRating'));
    }

    public function show($id)
    {
        $karyawan = Karyawan::with(['jabatan', 'rating'])
            ->where('status', 'Aktif')
            ->findOrFail($id);

        return view('karyawan.karyawan.show', compact('karyawan'));
    }
}
