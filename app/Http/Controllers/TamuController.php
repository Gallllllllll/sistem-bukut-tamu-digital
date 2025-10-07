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





    // Statistik jumlah tamu per hari
    public function statistik()
    {
        $tamuPerHari = Tamu::selectRaw('DATE(waktu_kedatangan) as tanggal, COUNT(*) as jumlah')
            ->groupBy('tanggal')
            ->get();

        return view('tamus.statistik', compact('tamuPerHari'));
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
