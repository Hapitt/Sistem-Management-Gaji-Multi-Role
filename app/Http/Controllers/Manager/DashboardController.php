<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'manager']);
    }

    public function index()
    {
        $user = Auth::user();
        $tanggal = Carbon::now()->translatedFormat('l, d F Y');

        return view('manager.dashboard', compact('user', 'tanggal'));
    }
}
