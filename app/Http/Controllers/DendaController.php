<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Peminjaman;
use App\Exports\DendaExport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DendaController extends Controller
{
    public function index()
    {
        $dendas = Denda::with('peminjaman.buku', 'peminjaman.siswa')->get();
        return view('denda.index', compact('dendas'));
    }

    public function create()
    {
        $peminjamans = Peminjaman::where('status_peminjaman', 'terlambat')
            ->orWhere(function ($query) {
                $query->where('status_peminjaman', 'dipinjam')
                      ->where('tanggal_pengembalian', '<', Carbon::now());
            })
            ->whereDoesntHave('denda')
            ->with(['buku', 'siswa'])
            ->get();
            
        return view('denda.create', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_peminjaman' => 'required|exists:peminjamans,id_peminjaman',
            'jumlah_denda_perhari' => 'required|numeric|min:0',
            'denda_hilang' => 'nullable|numeric|min:0',
            'total_denda_keseluruhan' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:lunas,belum_lunas',
            'tanggal_pembayaran' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        Denda::create($request->all());

        return redirect()->route('denda.index')
                ->with('success', 'Data denda berhasil ditambahkan');
    }

    public function show(Denda $denda)
    {
        $denda->load('peminjaman.buku', 'peminjaman.siswa');
        return view('denda.show', compact('denda'));
    }

    public function edit(Denda $denda)
    {
        $peminjamans = Peminjaman::where(function ($query) {
                $query->where('status_peminjaman', 'terlambat')
                    ->orWhere(function ($q) {
                        $q->where('status_peminjaman', 'dipinjam')
                          ->where('tanggal_pengembalian', '<', Carbon::now());
                    });
            })
            ->with(['buku', 'siswa'])
            ->get();
            
        return view('denda.edit', compact('denda', 'peminjamans'));
    }

    public function update(Request $request, Denda $denda)
    {
        $validator = Validator::make($request->all(), [
            'id_peminjaman' => 'required|exists:peminjamans,id_peminjaman',
            'jumlah_denda_perhari' => 'required|numeric|min:0',
            'denda_hilang' => 'nullable|numeric|min:0',
            'total_denda_keseluruhan' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:lunas,belum_lunas',
            'tanggal_pembayaran' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $denda->update($request->all());

        return redirect()->route('denda.index')
                ->with('success', 'Data denda berhasil diperbarui');
    }

    public function destroy(Denda $denda)
    {
        $denda->delete();

        return redirect()->route('denda.index')
                ->with('success', 'Data denda berhasil dihapus');
    }

    public function payFine(Denda $denda)
    {
        $denda->update([
            'status_pembayaran' => 'lunas',
            'tanggal_pembayaran' => Carbon::now()->toDateString()
        ]);

        return redirect()->route('denda.index')
                ->with('success', 'Pembayaran denda berhasil dicatat');
    }

    public function report(Request $request)
    {
        $query = Denda::with('peminjaman.buku', 'peminjaman.siswa');
        
        // Filter berdasarkan status pembayaran jika ada
        if ($request->has('status_pembayaran') && $request->status_pembayaran != '') {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }
        
        // Filter berdasarkan rentang tanggal jika ada
        if ($request->has('tanggal_mulai') && $request->tanggal_mulai != '') {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->has('tanggal_akhir') && $request->tanggal_akhir != '') {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }
        
        $dendas = $query->get();
        
        // Hitung total denda
        $totalDenda = $dendas->sum('total_denda_keseluruhan');
        $totalDendaLunas = $dendas->where('status_pembayaran', 'lunas')->sum('total_denda_keseluruhan');
        $totalDendaBelumLunas = $dendas->where('status_pembayaran', 'belum_lunas')->sum('total_denda_keseluruhan');
        
        return view('denda.report', compact(
            'dendas', 
            'totalDenda', 
            'totalDendaLunas', 
            'totalDendaBelumLunas'
        ));
    }
    
    public function calculateLateFee(Request $request)
    {
        $peminjaman = Peminjaman::findOrFail($request->id_peminjaman);
        $tanggalPengembalian = Carbon::parse($peminjaman->tanggal_pengembalian);
        $hariIni = Carbon::now();
        
        // Hitung jumlah hari terlambat
        $jumlahHariTerlambat = max(0, $hariIni->diffInDays($tanggalPengembalian, false));
        
        // Hitung denda berdasarkan jumlah hari dan tarif denda per hari
        $dendaPerHari = $request->jumlah_denda_perhari;
        $dendaHilang = $request->denda_hilang ?? 0;
        $totalDenda = ($jumlahHariTerlambat * $dendaPerHari) + $dendaHilang;
        
        return response()->json([
            'jumlah_hari_terlambat' => $jumlahHariTerlambat,
            'total_denda' => $totalDenda
        ]);
    }
    public function export(Request $request)
{
    // You'll need to install and use a package like maatwebsite/excel
    // This is a basic implementation example
    
    $query = Denda::query()->with('peminjaman.member');
    
    // Apply the same filters as in your report method
    if ($request->filled('status_pembayaran')) {
        $query->where('status_pembayaran', $request->status_pembayaran);
    }
    
    if ($request->filled('tanggal_mulai')) {
        $query->whereDate('tanggal_denda', '>=', $request->tanggal_mulai);
    }
    
    if ($request->filled('tanggal_akhir')) {
        $query->whereDate('tanggal_denda', '<=', $request->tanggal_akhir);
    }
    
    if ($request->filled('member')) {
        $query->whereHas('peminjaman.member', function($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->member . '%');
        });
    }
    
    $dendas = $query->get();
    
    // For Excel export, you'd typically use a library like Laravel Excel
    return Excel::download(new DendaExport($dendas), 'laporan-denda.xlsx');
}
}