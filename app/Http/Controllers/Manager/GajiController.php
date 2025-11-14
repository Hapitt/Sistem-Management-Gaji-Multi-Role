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
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Exception;

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

        
        $user = Auth::user();
        $managerDivisi = optional($user->karyawan)->divisi;

        
        if (!$managerDivisi) {
            $gaji = Gaji::whereRaw('0 = 1')->paginate(10); 
            return view('manager.gaji.index', compact('gaji', 'search', 'periode', 'filterSerah', 'managerDivisi'));
        }

        $gaji = Gaji::with(['karyawan', 'lembur'])
            ->whereHas('karyawan', function ($q) use ($managerDivisi) {
                $q->where('divisi', $managerDivisi);
            })
            ->when($search, function ($q) use ($search) {
                $q->whereHas('karyawan', function ($qq) use ($search) {
                    $qq->where('nama', 'like', "%{$search}%");
                });
            })
            ->when($periode, function ($q) use ($periode) {
                
                try {
                    $dt = Carbon::parse(strlen($periode) === 7 ? $periode . '-01' : $periode);
                    $q->whereMonth('periode', $dt->month)->whereYear('periode', $dt->year);
                } catch (\Exception $e) {
                    
                }
            })
            ->when($filterSerah, function ($q) use ($filterSerah) {
                $q->where('serahkan', $filterSerah);
            })
            ->orderBy('id_gaji', 'desc')
            ->paginate(10);

        return view('manager.gaji.index', compact('gaji', 'search', 'periode', 'filterSerah', 'managerDivisi'));
    }

    public function show($id)
    {
        $gaji = Gaji::with(['karyawan.jabatan', 'karyawan.rating', 'lembur'])->findOrFail($id);

        $user = Auth::user();
        $managerDivisi = optional($user->karyawan)->divisi;

        if (!$managerDivisi || $gaji->karyawan->divisi !== $managerDivisi) {
            abort(403, 'Anda tidak memiliki akses ke data gaji ini.');
        }

        return view('manager.gaji.show', compact('gaji'));
    }

    public function calculate()
    {
        $user = Auth::user();
        $managerDivisi = optional($user->karyawan)->divisi;
        $managerId = optional($user->karyawan)->id_karyawan;

        if (!$managerDivisi) {
            return redirect()->route('manager.gaji.index')->with('error', 'Anda belum terhubung ke data karyawan. Hubungi admin.');
        }

        
        $karyawan = Karyawan::where('divisi', $managerDivisi)
            ->when($managerId, fn($q) => $q->where('id_karyawan', '!=', $managerId))
            ->get();

        $lembur = Lembur::all();

        return view('manager.gaji.calculate', compact('karyawan', 'lembur', 'managerDivisi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'id_lembur' => 'required|exists:lembur,id_lembur',
            'periode' => 'required', // we will parse below
            'lama_lembur' => 'required|integer|min:0',
        ]);

        $user = Auth::user();
        $managerDivisi = optional($user->karyawan)->divisi;
        $managerId = optional($user->karyawan)->id_karyawan;

        $karyawan = Karyawan::findOrFail($request->id_karyawan);

        if (!$managerDivisi || $karyawan->divisi !== $managerDivisi) {
            return back()->withInput()->withErrors(['id_karyawan' => 'Anda hanya dapat menambah gaji untuk karyawan di divisi ' . ($managerDivisi ?? 'tidak diketahui')]);
        }

        if ($managerId && $request->id_karyawan == $managerId) {
            return back()->withInput()->withErrors(['id_karyawan' => 'Anda tidak dapat menambah gaji untuk diri sendiri.']);
        }

       
        try {
            $periodeInput = $request->periode;
            $dt = Carbon::parse(strlen($periodeInput) === 7 ? $periodeInput . '-01' : $periodeInput);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['periode' => 'Format periode tidak valid. Gunakan YYYY-MM.']);
        }

        
        $exists = Gaji::where('id_karyawan', $request->id_karyawan)
            ->whereMonth('periode', $dt->month)
            ->whereYear('periode', $dt->year)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['periode' => 'Gaji untuk karyawan dan periode yang sama sudah ada.']);
        }

        DB::beginTransaction();
        try {
            
            $karyawanData = DB::table('karyawan')
                ->join('jabatan', 'karyawan.id_jabatan', '=', 'jabatan.id_jabatan')
                ->join('rating', 'karyawan.id_rating', '=', 'rating.id_rating')
                ->where('karyawan.id_karyawan', $request->id_karyawan)
                ->select('jabatan.gaji_pokok', 'jabatan.tunjangan', 'rating.presentase_bonus')
                ->first();

            $lembur = DB::table('lembur')->where('id_lembur', $request->id_lembur)->first();

            if (!$karyawanData || !$lembur) {
                DB::rollBack();
                return back()->withErrors(['msg' => 'Data karyawan atau tarif lembur tidak ditemukan.']);
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
                'periode' => $dt->startOfMonth()->toDateString(),
                'total_lembur' => $total_lembur,
                'total_bonus' => $total_bonus,
                'total_tunjangan' => $total_tunjangan,
                'total_pendapatan' => $total_pendapatan,
                'serahkan' => 'belum',
            ]);

            DB::commit();
            return redirect()->route('manager.gaji.index')->with('success', 'Gaji berhasil dihitung dan disimpan.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gaji store error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['msg' => 'Terjadi kesalahan saat menyimpan gaji.']);
        }
    }

    public function cetak($id)
    {
        $gaji = Gaji::with(['karyawan', 'lembur'])->findOrFail($id);

        $user = Auth::user();
        $managerDivisi = optional($user->karyawan)->divisi;

        if (!$managerDivisi || $gaji->karyawan->divisi !== $managerDivisi) {
            abort(403, 'Anda tidak memiliki akses ke data gaji ini.');
        }

        $karyawan = DB::table('karyawan')
            ->join('jabatan', 'karyawan.id_jabatan', '=', 'jabatan.id_jabatan')
            ->join('rating', 'karyawan.id_rating', '=', 'rating.id_rating')
            ->where('karyawan.id_karyawan', $gaji->id_karyawan)
            ->select('karyawan.nama', 'jabatan.jabatan as nama_jabatan', 'jabatan.gaji_pokok', 'jabatan.tunjangan', 'rating.presentase_bonus', 'rating.rating')
            ->first();

        $pdf = Pdf::loadView('manager.gaji.cetak', compact('gaji', 'karyawan'))->setPaper('A4', 'portrait');

        return $pdf->download('Struk_Gaji_' . ($karyawan->nama ?? 'gaji') . '.pdf');
    }

    public function checkPeriod(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id_karyawan',
            'periode' => 'required',
        ]);

        $karyawan = Karyawan::findOrFail($validated['karyawan_id']);
        $user = Auth::user();
        $managerDivisi = optional($user->karyawan)->divisi;

        if (!$managerDivisi || $karyawan->divisi !== $managerDivisi) {
            return response()->json([
                'exists' => false,
                'message' => 'Anda tidak memiliki akses ke karyawan ini'
            ], 403);
        }

        try {
            $dt = Carbon::parse(strlen($validated['periode']) === 7 ? $validated['periode'] . '-01' : $validated['periode']);
        } catch (\Exception $e) {
            return response()->json(['exists' => false, 'message' => 'Format periode tidak valid'], 422);
        }

        $exists = Gaji::where('id_karyawan', $validated['karyawan_id'])
            ->whereMonth('periode', $dt->month)
            ->whereYear('periode', $dt->year)
            ->exists();

        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Gaji untuk periode ini sudah ada' : 'Periode tersedia'
        ]);
    }
}
