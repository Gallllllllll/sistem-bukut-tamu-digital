<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TamuExport;
use PDF;



class TamuController extends Controller
{
    // Menampilkan daftar tamu + pencarian
    public function index(Request $request)
{
    // Ambil query dari form pencarian (input name="search")
    $query = Tamu::query();

    if ($request->has('search') && !empty($request->search)) {
        $s = $request->search;
        $query->where('nama', 'like', "%$s%")
              ->orWhere('instansi', 'like', "%$s%")
              ->orWhereDate('waktu_kedatangan', $s);
    }

    // Urutkan berdasarkan waktu kedatangan terbaru
    $tamus = $query->orderBy('waktu_kedatangan', 'desc')->get();

    // Kirim ke view
    return view('tamus.index', compact('tamus'));
}


    // Form tambah tamu
    public function create()
    {
        return view('tamus.create');
    }

    // Simpan tamu baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'instansi' => 'required|string',
            'tujuan' => 'required|string',
            'waktu_kedatangan' => 'nullable|date',
        ]);


        Tamu::create($request->except('_token'));
        // return redirect()->route('tamus.index')->with('success', 'Tamu baru sudah masuk!');
         return back()->with('success', 'Tamu baru sudah masuk!');
    }

    //Hapus data tamu
    public function destroy($id)
    {
        $tamu = \App\Models\Tamu::findOrFail($id);
        $tamu->delete();

        return redirect()->route('tamus.index')->with('success', 'Data tamu berhasil dihapus!');
    }


    
   // Statistik jumlah tamu per hari dan per aktivitas
    public function statistik()
    {
        // Total keseluruhan
        $totalTamu = \App\Models\Tamu::count();

        // Total bulan ini
        $totalBulanIni = \App\Models\Tamu::whereMonth('waktu_kedatangan', now()->month)->count();

        // Total hari ini
        $totalHariIni = \App\Models\Tamu::whereDate('waktu_kedatangan', now()->toDateString())->count();

        // Data untuk grafik jumlah tamu per hari
        $tamuPerHari = \App\Models\Tamu::selectRaw('DATE(waktu_kedatangan) as tanggal, COUNT(*) as jumlah')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Data untuk grafik jumlah tamu per aktivitas
        // Pastikan kolom `aktivitas` ada di tabel tamu
        $tamuPerAktivitas = \App\Models\Tamu::selectRaw('tujuan as aktivitas, COUNT(*) as jumlah')
            ->groupBy('aktivitas')
            ->orderBy('aktivitas')
            ->get();

        return view('tamus.statistik', compact(
            'totalTamu',
            'totalBulanIni',
            'totalHariIni',
            'tamuPerHari',
            'tamuPerAktivitas'
        ));
    }


    // Export Excel
    public function exportExcel()
    {
        return Excel::download(new TamuExport, 'tamu.xlsx');
    }

    // Export PDF
    public function exportPDF()
    {
        $tamus = Tamu::all();
        $pdf = PDF::loadView('tamus.pdf', compact('tamus'));
        return $pdf->download('tamu.pdf');
    }
    
}
