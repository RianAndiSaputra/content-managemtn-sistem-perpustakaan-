@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="display-4 text-primary mb-2">
                    <i class="fas fa-book"></i>
                </div>
                <h5 class="card-title">Total Buku</h5>
                <p class="display-5 fw-bold">{{ App\Models\Buku::count() }}</p>
                <a href="{{ route('buku.index') }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="display-4 text-success mb-2">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h5 class="card-title">Total Siswa</h5>
                <p class="display-5 fw-bold">{{ App\Models\Siswa::count() }}</p>
                <a href="{{ route('siswa.index') }}" class="btn btn-sm btn-outline-success">Lihat Detail</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="display-4 text-warning mb-2">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h5 class="card-title">Peminjaman Aktif</h5>
                <p class="display-5 fw-bold">{{ App\Models\Peminjaman::where('status_peminjaman', 'dipinjam')->count() }}</p>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-warning">Lihat Detail</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="display-4 text-danger mb-2">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h5 class="card-title">Denda Belum Lunas</h5>
                <p class="display-5 fw-bold">{{ App\Models\Denda::where('status_pembayaran', 'belum_lunas')->count() }}</p>
                <a href="{{ route('denda.index') }}" class="btn btn-sm btn-outline-danger">Lihat Detail</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Peminjaman Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Buku</th>
                                <th>Siswa</th>
                                <th>Tgl Pinjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(App\Models\Peminjaman::with(['buku', 'siswa'])->latest()->take(5)->get() as $peminjaman)
                            <tr>
                                <td>{{ $peminjaman->buku->judul_buku }}</td>
                                <td>{{ $peminjaman->siswa->nama_siswa }}</td>
                                <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d/m/Y') }}</td>
                                <td>
                                    @if($peminjaman->status_peminjaman == 'dipinjam')
                                        <span class="badge bg-primary">Dipinjam</span>
                                    @elseif($peminjaman->status_peminjaman == 'dikembalikan')
                                        <span class="badge bg-success">Dikembalikan</span>
                                    @else
                                        <span class="badge bg-danger">Terlambat</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Buku Terpopuler</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Kategori</th>
                                <th>Jumlah Dipinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(App\Models\Buku::withCount('peminjamans')->orderBy('peminjamans_count', 'desc')->take(5)->get() as $buku)
                            <tr>
                                <td>{{ $buku->judul_buku }}</td>
                                <td>{{ $buku->penulis_buku }}</td>
                                <td>{{ $buku->kategori_buku }}</td>
                                <td>{{ $buku->peminjamans_count }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection