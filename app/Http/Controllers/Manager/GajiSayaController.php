<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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

        // Ambil id_karyawan manager yang login
        $managerId = optional(Auth::user()->karyawan)->id_karyawan;

        if (!$managerId) {
            $gaji = Gaji::whereRaw('0 = 1')->paginate(10);
            return view('manager.gaji-saya.index', compact('gaji', 'search', 'periode'));
        }

        $gaji = Gaji::with(['karyawan', 'lembur'])
            ->where('id_karyawan', $managerId)
            ->where('serahkan', 'sudah')
            ->when($search, function ($query) use ($search) {
                // cari di nama karyawan juga mungkin
                $query->whereHas('karyawan', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })->orWhere('periode', 'like', "%{$search}%");
            })
            ->when($periode, function ($query, $periode) {
                try {
                    $dt = Carbon::parse(strlen($periode) === 7 ? $periode . '-01' : $periode);
                    $query->whereMonth('periode', $dt->month)->whereYear('periode', $dt->year);
                } catch (\Exception $e) {
                    // abaikan filter jika gagal parse
                }
            })
            ->orderBy('periode', 'desc')
            ->orderBy('id_gaji', 'desc')
            ->paginate(10);

        return view('manager.gaji-saya.index', compact('gaji', 'search', 'periode'));
    }

    public function show($id)
    {
        $managerId = optional(Auth::user()->karyawan)->id_karyawan;

        $gaji = Gaji::with(['karyawan.jabatan', 'karyawan.rating', 'lembur'])
            ->where('id_gaji', $id)
            ->where('id_karyawan', $managerId)
            ->where('serahkan', 'sudah')
            ->firstOrFail();

        return view('manager.gaji-saya.show', compact('gaji'));
    }

    public function cetak($id)
    {
        $managerId = optional(Auth::user()->karyawan)->id_karyawan;

        $gaji = Gaji::with(['karyawan.jabatan', 'karyawan.rating', 'lembur'])
            ->where('id_gaji', $id)
            ->where('id_karyawan', $managerId)
            ->where('serahkan', 'sudah')
            ->firstOrFail();

        $pdf = Pdf::loadView('manager.gaji-saya.cetak', compact('gaji'));
        return $pdf->download('Slip_Gaji_' . $gaji->karyawan->nama . '.pdf');
    }
}
