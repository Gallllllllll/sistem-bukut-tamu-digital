<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TamuExport;
use PDF;
use Barryvdh\DomPDF\Facade\Pdf as DomPdf;
use Carbon\Carbon;

class TamuController extends Controller
{
    // Menampilkan daftar tamu + pencarian
    public function index(Request $request)
    {
        $query = Tamu::query();

        if ($request->has('search') && !empty($request->search)) {
            $s = $request->search;
            $query->where('nama', 'like', "%$s%")
                  ->orWhere('instansi', 'like', "%$s%")
                  ->orWhereDate('waktu_kedatangan', $s);
        }

        $tamus = $query->orderBy('waktu_kedatangan', 'desc')->get();
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
        return back()->with('success', 'Tamu baru sudah masuk!');
    }

    // Hapus data tamu
    public function destroy($id)
    {
        $tamu = Tamu::findOrFail($id);
        $tamu->delete();

        return redirect()->route('tamus.index')->with('success', 'Data tamu berhasil dihapus!');
    }

    // Statistik jumlah tamu per hari dan per aktivitas
    public function statistik()
    {
        $totalTamu = Tamu::count();
        $totalBulanIni = Tamu::whereMonth('waktu_kedatangan', now()->month)->count();
        $totalHariIni = Tamu::whereDate('waktu_kedatangan', now()->toDateString())->count();

        $tamuPerHari = Tamu::selectRaw('DATE(waktu_kedatangan) as tanggal, COUNT(*) as jumlah')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($item) {
                $item->tanggal = Carbon::parse($item->tanggal)->format('Y-m-d');
                return $item;
            });

        $tamuPerAktivitas = Tamu::selectRaw('tujuan as aktivitas, COUNT(*) as jumlah')
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

    // Export Statistik
    public function exportStatistik()
    {
        $data = \App\Models\Tamu::selectRaw('DATE(waktu_kedatangan) as tanggal, COUNT(*) as jumlah')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $terakhir = \App\Models\Tamu::orderBy('waktu_kedatangan', 'desc')->first()->waktu_kedatangan ?? now()->toDateString();

        $pdf = DomPdf::loadView('tamus.pdf_statistik', compact('data', 'terakhir'));

        return $pdf->download('statistik_tamu.pdf');
    }

    // Edit dan Update untuk tamu
    public function edit($id)
    {
        $tamu = Tamu::findOrFail($id);
        return view('tamus.edit', compact('tamu'));
    }

    public function update(Request $request, $id)
    {
        $tamu = Tamu::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
        ]);

        $tamu->update([
            'nama' => $request->nama,
            'instansi' => $request->instansi,
            'tujuan' => $request->tujuan,
        ]);

        return redirect()->route('tamus.index')->with('success', 'Data tamu berhasil diperbarui!');
    }
}
