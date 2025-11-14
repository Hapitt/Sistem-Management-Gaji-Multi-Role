<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class GajiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'karyawan']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $periode = $request->input('periode');


        $userId = Auth::id();


        $gaji = Gaji::with(['karyawan', 'lembur'])
            ->whereHas('karyawan', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('serahkan', 'sudah') 
            ->when($search, function ($query) use ($search) {

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

        return view('karyawan.gaji.index', compact('gaji', 'search', 'periode'));
    }

    public function show($id)
    {
        $userId = Auth::id();

        $gaji = Gaji::with(['karyawan.jabatan', 'karyawan.rating', 'lembur'])
            ->where('id_gaji', $id)
            ->where('serahkan', 'sudah') 
            ->whereHas('karyawan', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->firstOrFail();

        return view('karyawan.gaji.show', compact('gaji'));
    }

    

    public function cetak($id)
    {
        $userId = Auth::id();

        $gaji = Gaji::with(['karyawan.jabatan', 'karyawan.rating', 'lembur'])
            ->where('id_gaji', $id)
            ->where('serahkan', 'sudah')
            ->whereHas('karyawan', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->firstOrFail();


        $pdf = Pdf::loadView('karyawan.gaji.cetak', compact('gaji'));


        return $pdf->download('Slip_Gaji_' . $gaji->karyawan->nama . '.pdf');
    }
}
