<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Denda;
use App\Models\Peminjaman;
use App\Models\PetugasPerpustakaan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['buku', 'siswa', 'petugas'])->get();
        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $bukus = Buku::where('jumlah_buku_tersedia', '>', 0)->get();
        $siswas = Siswa::all();
        $petugass = PetugasPerpustakaan::all();
        
        return view('peminjaman.create', compact('bukus', 'siswas', 'petugass'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_buku' => 'required|exists:bukus,id_buku',
            'id_siswa' => 'required|exists:siswas,id_siswa',
            'id_petugas' => 'required|exists:petugas_perpustakaans,id_petugas',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after:tanggal_peminjaman',
        ]);

        if ($validator->fails()) {
            return redirect()->route('peminjaman.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Periksa ketersediaan buku
        $buku = Buku::findOrFail($request->id_buku);
        if ($buku->jumlah_buku_tersedia <= 0) {
            return redirect()->route('peminjaman.create')
                ->with('error', 'Buku tidak tersedia untuk dipinjam!')
                ->withInput();
        }

        // Kurangi jumlah buku yang tersedia
        $buku->jumlah_buku_tersedia -= 1;
        $buku->save();

        // Buat peminjaman baru
        $peminjaman = Peminjaman::create([
            'id_buku' => $request->id_buku,
            'id_siswa' => $request->id_siswa,
            'id_petugas' => $request->id_petugas,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'status_peminjaman' => 'dipinjam',
        ]);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan!');
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['buku', 'siswa', 'petugas', 'denda']);
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        $bukus = Buku::all();
        $siswas = Siswa::all();
        $petugass = PetugasPerpustakaan::all();
        
        return view('peminjaman.edit', compact('peminjaman', 'bukus', 'siswas', 'petugass'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validator = Validator::make($request->all(), [
            'status_peminjaman' => 'required|in:dipinjam,dikembalikan,terlambat',
        ]);

        if ($validator->fails()) {
            return redirect()->route('peminjaman.edit', $peminjaman->id_peminjaman)
                ->withErrors($validator)
                ->withInput();
        }

        // Jika status berubah dari 'dipinjam' ke 'dikembalikan'
        if ($peminjaman->status_peminjaman == 'dipinjam' && $request->status_peminjaman == 'dikembalikan') {
            // Tambah jumlah buku yang tersedia
            $buku = Buku::findOrFail($peminjaman->id_buku);
            $buku->jumlah_buku_tersedia += 1;
            $buku->save();
            
            // Cek keterlambatan
            $tanggalPengembalian = Carbon::parse($peminjaman->tanggal_pengembalian);
            $today = Carbon::now();
            
            if ($today->gt($tanggalPengembalian)) {
                // Hitung denda
                $hariTerlambat = $today->diffInDays($tanggalPengembalian);
                $dendaPerHari = 5000; // Asumsi denda Rp 5.000 per hari
                $totalDenda = $hariTerlambat * $dendaPerHari;
                
                // Buat atau update denda
                Denda::updateOrCreate(
                    ['id_peminjaman' => $peminjaman->id_peminjaman],
                    [
                        'jumlah_denda_perhari' => $dendaPerHari,
                        'total_denda_keseluruhan' => $totalDenda,
                        'status_pembayaran' => 'belum_lunas',
                    ]
                );
            }
        }

        $peminjaman->update([
            'status_peminjaman' => $request->status_peminjaman
        ]);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Status peminjaman berhasil diperbarui!');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        try {
            // Jika status masih "dipinjam", tambahkan kembali stok buku
            if ($peminjaman->status_peminjaman == 'dipinjam') {
                $buku = Buku::findOrFail($peminjaman->id_buku);
                $buku->jumlah_buku_tersedia += 1;
                $buku->save();
            }
            
            $peminjaman->delete();
            return redirect()->route('peminjaman.index')
                ->with('success', 'Peminjaman berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Peminjaman tidak dapat dihapus karena masih terkait dengan data lain!');
        }
    }
}