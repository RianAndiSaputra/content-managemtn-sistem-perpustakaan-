@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Detail Peminjaman</span>
                    <div>
                        <a href="{{ route('peminjaman.edit', $peminjaman->id_peminjaman) }}" class="btn btn-warning btn-sm mx-1">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <h5>Informasi Peminjaman</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Judul Buku</th>
                            <td>{{ $peminjaman->buku->judul_buku }}</td>
                        </tr>
                        <tr>
                            <th>Peminjam</th>
                            <td>{{ $peminjaman->siswa->nama_siswa }} ({{ $peminjaman->siswa->nisn_siswa }})</td>
                        </tr>
                        <tr>
                            <th>Petugas</th>
                            <td>{{ $peminjaman->petugas->nama_petugas }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Peminjaman</th>
                            <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengembalian</th>
                            <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($peminjaman->status_peminjaman == 'dipinjam')
                                    <span class="badge bg-info">Dipinjam</span>
                                @elseif($peminjaman->status_peminjaman == 'dikembalikan')
                                    <span class="badge bg-success">Dikembalikan</span>
                                @elseif($peminjaman->status_peminjaman == 'terlambat')
                                    <span class="badge bg-danger">Terlambat</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    @if($peminjaman->denda)
                    <h5 class="mt-4">Informasi Denda</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Denda per Hari</th>
                            <td>Rp {{ number_format($peminjaman->denda->jumlah_denda_perhari, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Total Denda</th>
                            <td>Rp {{ number_format($peminjaman->denda->total_denda_keseluruhan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Status Pembayaran</th>
                            <td>
                                @if($peminjaman->denda->status_pembayaran == 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-danger">Belum Lunas</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                    @endif

                    <div class="mt-3">
                        <form action="{{ route('peminjaman.destroy', $peminjaman->id_peminjaman) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data peminjaman ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection