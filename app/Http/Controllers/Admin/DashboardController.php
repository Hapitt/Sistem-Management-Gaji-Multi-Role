<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Auth;
use App\Models\Jabatan;
use App\Models\Gaji;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        
        $totalKaryawan = Karyawan::count();
        $totalJabatan = Jabatan::count();
        $totalLembur = Gaji::sum('lama_lembur') ?? 0;
        $totalGaji = Gaji::sum('total_pendapatan') ?? 0;

        
        $karyawans = Karyawan::with(['jabatan', 'rating'])->latest('created_at')->paginate(5);

        return view('admin.dashboard', compact(
            'totalKaryawan',
            'totalJabatan',
            'totalLembur',
            'totalGaji',
            'karyawans',
            'user'
        ));
    }
}
