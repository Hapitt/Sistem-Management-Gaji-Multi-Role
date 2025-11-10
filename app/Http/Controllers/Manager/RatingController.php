<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'manager']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $ratings = Rating::when($search, function ($query, $search) {
            $query->where('rating', 'like', "%{$search}%");
        })->orderBy('rating', 'asc')->get();

        return view('manager.rating.index', compact('ratings', 'search'));
    }
}
