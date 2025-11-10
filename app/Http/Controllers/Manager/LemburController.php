<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Lembur;
use Illuminate\Http\Request;

class LemburController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'manager']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $lemburs = Lembur::when($search, fn($q) => $q->where('tarif', 'like', "%{$search}%"))
            ->orderBy('id_lembur', 'asc')
            ->get();

        return view('manager.lembur.index', compact('lemburs', 'search'));
    }

    public function show($id)
    {
        $lembur = Lembur::findOrFail($id);
        return view('manager.lembur.show', compact('lembur'));
    }
}
