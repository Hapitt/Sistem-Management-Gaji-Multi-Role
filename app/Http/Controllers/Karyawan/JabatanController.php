<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'karyawan']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $jabatans = Jabatan::when($search, fn($q) => $q->where('jabatan', 'like', "%{$search}%"))
            ->orderBy('jabatan', 'asc')
            ->paginate(10);

        return view('karyawan.jabatan.index', compact('jabatans', 'search'));
    }
}
