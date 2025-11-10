<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\Lembur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class GajiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'manager']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $periode = $request->input('periode');
        $filterSerah = $request->input('serah');

        // Ambil divisi manager yang sedang login
        $user = Auth::user();
        $managerDivisi = $user->karyawan->divisi ?? null;

        $gaji = Gaji::with(['karyawan', 'lembur'])
            ->whereHas('karyawan', function ($query) use ($managerDivisi) {
                $query->where('divisi', $managerDivisi);
            })
            ->when($search, fn($q) => $q->whereHas('karyawan', fn($qq) => $qq->where('nama', 'like', "%{$search}%")))
            ->when($periode, function ($query, $periode) {
                // Konversi format periode dari YYYY-MM menjadi YYYY-MM-01 untuk filtering
                $periodeDate = $periode . '-01';
                $bulan = date('m', strtotime($periodeDate));
                $tahun = date('Y', strtotime($periodeDate));
                $query->whereMonth('periode', $bulan)->whereYear('periode', $tahun);
            })
            ->when($filterSerah, fn($q) => $q->where('serahkan', $filterSerah))
            ->orderBy('id_gaji', 'desc')
            ->paginate(10);

        return view('manager.gaji.index', compact('gaji', 'search', 'periode', 'filterSerah', 'managerDivisi'));
    }

    public function show($id)
    {
        $gaji = Gaji::with(['karyawan.jabatan', 'karyawan.rating', 'lembur'])->findOrFail($id);

        // Cek apakah gaji ini milik karyawan di divisi manager
        $user = Auth::user();
        $managerDivisi = $user->karyawan->divisi ?? null;

        if ($gaji->karyawan->divisi !== $managerDivisi) {
            abort(403, 'Anda tidak memiliki akses ke data gaji ini.');
        }

        return view('manager.gaji.show', compact('gaji'));
    }

    public function calculate()
    {
        // Ambil divisi manager yang sedang login
        $user = Auth::user();
        $managerDivisi = $user->karyawan->divisi ?? null;
        $managerId = $user->karyawan->id_karyawan ?? null;

        // Ambil karyawan yang divisinya sama dengan manager, kecuali manager sendiri
        $karyawan = Karyawan::where('divisi', $managerDivisi)
            ->where('id_karyawan', '!=', $managerId) // Tidak bisa memasukkan gaji sendiri
            ->get();

        $lembur = Lembur::all();

        return view('manager.gaji.calculate', compact('karyawan', 'lembur', 'managerDivisi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'id_lembur' => 'required|exists:lembur,id_lembur',
            'periode' => 'required|date',
            'lama_lembur' => 'required|integer|min:0',
        ]);

        // Cek apakah karyawan berada di divisi yang sama dengan manager
        $karyawan = Karyawan::findOrFail($request->id_karyawan);
        $user = Auth::user();
        $managerDivisi = $user->karyawan->divisi ?? null;

        if ($karyawan->divisi !== $managerDivisi) {
            return back()->withInput()->withErrors(['id_karyawan' => 'Anda hanya dapat menambah gaji untuk karyawan di divisi ' . $managerDivisi]);
        }

        // Cek apakah manager mencoba menambah gaji sendiri
        $managerId = $user->karyawan->id_karyawan ?? null;
        if ($request->id_karyawan == $managerId) {
            return back()->withInput()->withErrors(['id_karyawan' => 'Anda tidak dapat menambah gaji untuk diri sendiri.']);
        }

        // Konversi format periode dari YYYY-MM menjadi YYYY-MM-01 (tanggal pertama bulan)
        $periode = $request->periode . '-01';

        // Cek apakah sudah ada gaji untuk karyawan dan periode yang sama
        $exists = Gaji::where('id_karyawan', $request->id_karyawan)
            ->whereDate('periode', $periode)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['periode' => 'Gaji untuk karyawan dan periode yang sama sudah ada.']);
        }

        // Hitung gaji
        $karyawanData = DB::table('karyawan')
            ->join('jabatan', 'karyawan.id_jabatan', '=', 'jabatan.id_jabatan')
            ->join('rating', 'karyawan.id_rating', '=', 'rating.id_rating')
            ->where('karyawan.id_karyawan', $request->id_karyawan)
            ->select('jabatan.gaji_pokok', 'jabatan.tunjangan', 'rating.presentase_bonus')
            ->first();

        $lembur = DB::table('lembur')->where('id_lembur', $request->id_lembur)->first();

        if (!$karyawanData || !$lembur) {
            return back()->withErrors(['msg' => 'Data karyawan atau lembur tidak ditemukan.']);
        }

        $gaji_pokok = $karyawanData->gaji_pokok;
        $tunjangan = $karyawanData->tunjangan;
        $presentase_bonus = $karyawanData->presentase_bonus;
        $tarif_lembur = $lembur->tarif;

        $total_lembur = $request->lama_lembur * $tarif_lembur;
        $total_bonus = $gaji_pokok * $presentase_bonus;
        $total_tunjangan = $tunjangan;
        $total_pendapatan = $gaji_pokok + $total_lembur + $total_bonus + $total_tunjangan;

        Gaji::create([
            'id_karyawan' => $request->id_karyawan,
            'id_lembur' => $request->id_lembur,
            'lama_lembur' => $request->lama_lembur,
            'periode' => $periode, // Gunakan periode yang sudah dikonversi
            'total_lembur' => $total_lembur,
            'total_bonus' => $total_bonus,
            'total_tunjangan' => $total_tunjangan,
            'total_pendapatan' => $total_pendapatan,
            'serahkan' => 'belum',
        ]);

        return redirect()->route('manager.gaji.index')->with('success', 'Gaji berhasil dihitung dan disimpan.');
    }

    public function cetak($id)
    {
        $gaji = Gaji::with(['karyawan', 'lembur'])->findOrFail($id);

        // Cek apakah gaji ini milik karyawan di divisi manager
        $user = Auth::user();
        $managerDivisi = $user->karyawan->divisi ?? null;

        if ($gaji->karyawan->divisi !== $managerDivisi) {
            abort(403, 'Anda tidak memiliki akses ke data gaji ini.');
        }

        $karyawan = DB::table('karyawan')
            ->join('jabatan', 'karyawan.id_jabatan', '=', 'jabatan.id_jabatan')
            ->join('rating', 'karyawan.id_rating', '=', 'rating.id_rating')
            ->where('karyawan.id_karyawan', $gaji->id_karyawan)
            ->select('karyawan.nama', 'jabatan.jabatan as nama_jabatan', 'jabatan.gaji_pokok', 'jabatan.tunjangan', 'rating.presentase_bonus', 'rating.rating')
            ->first();

        $pdf = Pdf::loadView('manager.gaji.cetak', compact('gaji', 'karyawan'))->setPaper('A4', 'portrait');

        return $pdf->download('Struk_Gaji_' . $karyawan->nama . '.pdf');
    }

    public function checkPeriod(Request $request)
    {
        try {
            $validated = $request->validate([
                'karyawan_id' => 'required|exists:karyawan,id_karyawan',
                'periode' => 'required|date',
            ]);

            // Cek apakah karyawan berada di divisi yang sama dengan manager
            $karyawan = Karyawan::findOrFail($validated['karyawan_id']);
            $user = Auth::user();
            $managerDivisi = $user->karyawan->divisi ?? null;

            if ($karyawan->divisi !== $managerDivisi) {
                return response()->json([
                    'exists' => false,
                    'message' => 'Anda tidak memiliki akses ke karyawan ini'
                ], 403);
            }

            // Konversi format periode dari YYYY-MM menjadi YYYY-MM-01
            $periode = $validated['periode'] . '-01';

            $exists = Gaji::where('id_karyawan', $validated['karyawan_id'])
                ->whereDate('periode', $periode)
                ->exists();

            return response()->json([
                'exists' => $exists,
                'message' => $exists ? 'Gaji untuk periode ini sudah ada' : 'Periode tersedia'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'exists' => false,
                'message' => 'Error memeriksa periode'
            ], 500);
        }
    }
}
