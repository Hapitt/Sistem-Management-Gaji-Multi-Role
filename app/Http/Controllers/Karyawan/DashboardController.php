<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'karyawan']);
    }

    public function index()
    {
        $user = Auth::user();

        return view('karyawan.dashboard', [
            'userName' => $user->name,
            'userEmail' => $user->email,
            'userRole' => $user->role
        ]);
    }
}
