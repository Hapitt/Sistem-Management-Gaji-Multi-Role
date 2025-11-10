<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class GajiSayaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'manager']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $periode = $request->input('periode');

        // Ambil user_id dari manager yang login
        $userId = Auth::id();
        $managerId = Auth::user()->karyawan->id_karyawan ?? null;

        // Query gaji hanya untuk manager yang login dan sudah diserahkan
        $gaji = Gaji::with(['karyawan', 'lembur'])
            ->where('id_karyawan', $managerId) // Hanya gaji manager sendiri
            ->where('serahkan', 'sudah') // Hanya gaji yang sudah diserahkan
            ->when($search, function ($query) use ($search) {
                // Search by periode format
                $query->where('periode', 'like', "%{$search}%");
            })
            ->when($periode, function ($query, $periode) {
                $bulan = date('m', strtotime($periode . '-01'));
                $tahun = date('Y', strtotime($periode . '-01'));
                $query->whereMonth('periode', $bulan)->whereYear('periode', $tahun);
            })
            ->orderBy('periode', 'desc')
            ->orderBy('id_gaji', 'desc')
            ->paginate(10);

        return view('manager.gaji-saya.index', compact('gaji', 'search', 'periode'));
    }

    public function show($id)
    {
        $managerId = Auth::user()->karyawan->id_karyawan ?? null;

        $gaji = Gaji::with(['karyawan.jabatan', 'karyawan.rating', 'lembur'])
            ->where('id_gaji', $id)
            ->where('id_karyawan', $managerId) // Hanya gaji manager sendiri
            ->where('serahkan', 'sudah') // Hanya yang sudah diserahkan
            ->firstOrFail();

        return view('manager.gaji-saya.show', compact('gaji'));
    }

    public function cetak($id)
    {
        $managerId = Auth::user()->karyawan->id_karyawan ?? null;

        $gaji = Gaji::with(['karyawan.jabatan', 'karyawan.rating', 'lembur'])
            ->where('id_gaji', $id)
            ->where('id_karyawan', $managerId) // Hanya gaji manager sendiri
            ->where('serahkan', 'sudah') // Hanya yang sudah diserahkan
            ->firstOrFail();

        // Buat PDF dari view
        $pdf = Pdf::loadView('manager.gaji-saya.cetak', compact('gaji'));

        // Download otomatis dengan nama file tertentu
        return $pdf->download('Slip_Gaji_' . $gaji->karyawan->nama . '.pdf');
    }
}
