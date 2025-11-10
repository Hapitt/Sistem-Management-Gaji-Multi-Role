<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lembur;
use Illuminate\Http\Request;

class LemburController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $lemburs = Lembur::when($search, fn($q) => $q->where('id_lembur', 'like', "%{$search}%")
            ->orWhere('tarif', 'like', "%{$search}%"))
            ->orderBy('id_lembur', 'asc')
            ->get();

        return view('admin.lembur.index', compact('lemburs', 'search'));
    }

    public function create()
    {
        return view('admin.lembur.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['tarif' => 'required|numeric|min:0']);
        Lembur::create($validated);

        return redirect()->route('admin.lembur.index')->with('success', 'Tarif lembur berhasil ditambahkan!');
    }

    public function show($id)
    {
        $lembur = Lembur::findOrFail($id);
        return view('admin.lembur.show', compact('lembur'));
    }

    public function edit($id)
    {
        $lembur = Lembur::findOrFail($id);
        return view('admin.lembur.edit', compact('lembur'));
    }

    public function update(Request $request, $id)
    {
        $lembur = Lembur::findOrFail($id);
        $validated = $request->validate(['tarif' => 'required|numeric|min:0']);
        $lembur->update($validated);
        return redirect()->route('admin.lembur.index')->with('success', 'Tarif lembur berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->delete();
        return redirect()->route('admin.lembur.index')->with('success', 'Tarif lembur berhasil dihapus!');
    }
}
