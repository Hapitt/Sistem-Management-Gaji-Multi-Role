<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'manager']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $jabatans = Jabatan::when($search, fn($q) => $q->where('jabatan', 'like', "%{$search}%"))
            ->orderBy('id_jabatan', 'asc')
            ->paginate(10);

        return view('manager.jabatan.index', compact('jabatans', 'search'));
    }

    public function show($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return view('manager.jabatan.show', compact('jabatan'));
    }
}
