<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $ratings = Rating::when($search, function ($query, $search) {
            if (str_contains($search, '%')) {
                $numeric = floatval(str_replace('%', '', $search)) / 100;
                $searchDecimal = (string) $numeric;
            } else {
                $searchDecimal = $search;
            }

            $query->where('rating', 'like', "%{$search}%")
                ->orWhere('presentase_bonus', 'like', "%{$searchDecimal}%");
        })->orderBy('id_rating', 'asc')->get();

        return view('admin.rating.index', compact('ratings', 'search'));
    }

    public function create()
    {
        return view('admin.rating.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|numeric',
            'presentase_bonus' => 'required|numeric|min:0|max:1',
        ]);

        $totalPresentase = Rating::sum('presentase_bonus') + $validated['presentase_bonus'];
        if ($totalPresentase > 1) {
            return back()->withInput()->withErrors(['presentase_bonus' => 'Total presentase bonus tidak boleh melebihi 100%!']);
        }

        Rating::create($validated);

        return redirect()->route('admin.rating.index')->with('success', 'Rating berhasil ditambahkan!');
    }

    public function show($id)
    {
        $rating = Rating::findOrFail($id);
        return view('admin.rating.show', compact('rating'));
    }

    public function edit($id)
    {
        $rating = Rating::findOrFail($id);
        return view('admin.rating.edit', compact('rating'));
    }

    public function update(Request $request, $id)
    {
        $rating = Rating::findOrFail($id);

        $validated = $request->validate([
            'rating' => 'required|numeric',
            'presentase_bonus' => 'required|numeric|min:0|max:1',
        ]);

        $totalPresentase = Rating::where('id_rating', '!=', $id)->sum('presentase_bonus') + $validated['presentase_bonus'];
        if ($totalPresentase > 1) {
            return back()->withInput()->withErrors(['presentase_bonus' => 'Total presentase bonus tidak boleh melebihi 100%!']);
        }

        $rating->update($validated);

        return redirect()->route('admin.rating.index')->with('success', 'Rating berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);
        $rating->delete();

        return redirect()->route('admin.rating.index')->with('success', 'Rating berhasil dihapus!');
    }
}
