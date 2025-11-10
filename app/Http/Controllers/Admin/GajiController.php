<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\Lembur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class GajiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $periode = $request->input('periode');
        $filterSerah = $request->input('serah');

        $gaji = Gaji::with(['karyawan', 'lembur'])
            ->when($search, fn($q) => $q->whereHas('karyawan', fn($qq) => $qq->where('nama', 'like', "%{$search}%")))
            ->when($periode, function ($query, $periode) {
                $bulan = date('m', strtotime($periode . '-01'));
                $tahun = date('Y', strtotime($periode . '-01'));
                $query->whereMonth('periode', $bulan)->whereYear('periode', $tahun);
            })
            ->when($filterSerah, fn($q) => $q->where('serahkan', $filterSerah))
            ->orderBy('id_gaji', 'desc')
            ->paginate(10);

        return view('admin.gaji.index', compact('gaji', 'search', 'periode', 'filterSerah'));
    }

    // ✅ TAMBAHKAN METHOD SHOW INI
    public function show($id)
    {
        $gaji = Gaji::with(['karyawan.jabatan', 'karyawan.rating', 'lembur'])->findOrFail($id);
        return view('admin.gaji.show', compact('gaji'));
    }

    public function calculate()
    {
        $karyawan = Karyawan::all();
        $lembur = Lembur::all();
        return view('admin.gaji.calculate', compact('karyawan', 'lembur'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'id_lembur' => 'required|exists:lembur,id_lembur',
            'periode' => 'required|date',
            'lama_lembur' => 'required|integer|min:0',
        ]);

        $exists = Gaji::where('id_karyawan', $request->id_karyawan)
            ->whereDate('periode', $request->periode)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['periode' => 'Gaji untuk karyawan dan periode yang sama sudah ada.']);
        }

        $karyawan = DB::table('karyawan')
            ->join('jabatan', 'karyawan.id_jabatan', '=', 'jabatan.id_jabatan')
            ->join('rating', 'karyawan.id_rating', '=', 'rating.id_rating')
            ->where('karyawan.id_karyawan', $request->id_karyawan)
            ->select('jabatan.gaji_pokok', 'jabatan.tunjangan', 'rating.presentase_bonus')
            ->first();

        $lembur = DB::table('lembur')->where('id_lembur', $request->id_lembur)->first();

        if (!$karyawan || !$lembur) {
            return back()->withErrors(['msg' => 'Data karyawan atau lembur tidak ditemukan.']);
        }

        $gaji_pokok = $karyawan->gaji_pokok;
        $tunjangan = $karyawan->tunjangan;
        $presentase_bonus = $karyawan->presentase_bonus;
        $tarif_lembur = $lembur->tarif;

        $total_lembur = $request->lama_lembur * $tarif_lembur;
        $total_bonus = $gaji_pokok * $presentase_bonus;
        $total_tunjangan = $tunjangan;
        $total_pendapatan = $gaji_pokok + $total_lembur + $total_bonus + $total_tunjangan;

        Gaji::create([
            'id_karyawan' => $request->id_karyawan,
            'id_lembur' => $request->id_lembur,
            'lama_lembur' => $request->lama_lembur,
            'periode' => $request->periode,
            'total_lembur' => $total_lembur,
            'total_bonus' => $total_bonus,
            'total_tunjangan' => $total_tunjangan,
            'total_pendapatan' => $total_pendapatan,
            'is_diserahkan' => false,
        ]);

        return redirect()->route('admin.gaji.index')->with('success', 'Gaji berhasil dihitung dan disimpan.');
    }

    public function edit($id)
    {
        $gaji = Gaji::findOrFail($id);
        $karyawan = Karyawan::all();
        $lembur = Lembur::all();
        return view('admin.gaji.edit', compact('gaji', 'karyawan', 'lembur'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'id_lembur' => 'required|exists:lembur,id_lembur',
            'periode' => 'required|date',
            'lama_lembur' => 'required|integer|min:0',
        ]);

        $gaji = Gaji::findOrFail($id);

        $karyawan = DB::table('karyawan')
            ->join('jabatan', 'karyawan.id_jabatan', '=', 'jabatan.id_jabatan')
            ->join('rating', 'karyawan.id_rating', '=', 'rating.id_rating')
            ->where('karyawan.id_karyawan', $request->id_karyawan)
            ->select('jabatan.gaji_pokok', 'jabatan.tunjangan', 'rating.presentase_bonus')
            ->first();

        $lembur = DB::table('lembur')->where('id_lembur', $request->id_lembur)->first();

        if (!$karyawan || !$lembur) {
            return back()->withErrors(['msg' => 'Data karyawan atau lembur tidak ditemukan.']);
        }

        $gaji_pokok = $karyawan->gaji_pokok;
        $tunjangan = $karyawan->tunjangan;
        $presentase_bonus = $karyawan->presentase_bonus;
        $tarif_lembur = $lembur->tarif;

        $total_lembur = $request->lama_lembur * $tarif_lembur;
        $total_bonus = $gaji_pokok * $presentase_bonus;
        $total_tunjangan = $tunjangan;
        $total_pendapatan = $gaji_pokok + $total_lembur + $total_bonus + $total_tunjangan;

        $gaji->update([
            'id_karyawan' => $request->id_karyawan,
            'id_lembur' => $request->id_lembur,
            'lama_lembur' => $request->lama_lembur,
            'periode' => $request->periode,
            'total_lembur' => $total_lembur,
            'total_bonus' => $total_bonus,
            'total_tunjangan' => $total_tunjangan,
            'total_pendapatan' => $total_pendapatan,
        ]);

        return redirect()->route('admin.gaji.index')->with('success', 'Gaji berhasil diperbarui dan dihitung ulang.');
    }

    public function destroy($id)
    {
        $gaji = Gaji::findOrFail($id);
        $gaji->delete();
        return redirect()->route('admin.gaji.index')->with('success', 'Data gaji berhasil dihapus');
    }

    public function cetak($id)
    {
        $gaji = Gaji::with(['karyawan', 'lembur'])->findOrFail($id);

        $karyawan = DB::table('karyawan')
            ->join('jabatan', 'karyawan.id_jabatan', '=', 'jabatan.id_jabatan')
            ->join('rating', 'karyawan.id_rating', '=', 'rating.id_rating')
            ->where('karyawan.id_karyawan', $gaji->id_karyawan)
            ->select('karyawan.nama', 'jabatan.jabatan as nama_jabatan', 'jabatan.gaji_pokok', 'jabatan.tunjangan', 'rating.presentase_bonus', 'rating.rating')
            ->first();

        $pdf = Pdf::loadView('admin.gaji.cetak', compact('gaji', 'karyawan'))->setPaper('A4', 'portrait');

        return $pdf->download('Struk_Gaji_' . $karyawan->nama . '.pdf');
    }

    public function serahkan($id)
    {
        $gaji = Gaji::with('karyawan')->findOrFail($id);

        // Cek apakah gaji sudah diserahkan
        if ($gaji->serahkan === 'sudah') {
            return redirect()->route('admin.gaji.index')
                ->with('error', 'Gaji ini sudah diserahkan sebelumnya.');
        }

        // Update status serahkan
        $gaji->update([
            'serahkan' => 'sudah',
            'tanggal_serah' => now(),
        ]);

        // TODO: Di sini nanti bisa ditambahkan pengiriman email/notifikasi ke karyawan

        return redirect()->route('admin.gaji.index')
            ->with('success', 'Struk gaji berhasil diserahkan kepada ' . $gaji->karyawan->nama);
    }

    public function checkPeriod(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'karyawan_id' => 'required|exists:karyawan,id_karyawan',
                'periode' => 'required|date',
            ]);

            // Cek apakah sudah ada gaji untuk karyawan dan periode yang sama
            $exists = Gaji::where('id_karyawan', $validated['karyawan_id'])
                ->whereDate('periode', $validated['periode'])
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
