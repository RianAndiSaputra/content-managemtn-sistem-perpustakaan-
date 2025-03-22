@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Detail Denda</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2">Informasi Peminjaman</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th style="width: 30%">Siswa</th>
                                    <td>{{ $denda->peminjaman->siswa->nama_siswa ?? 'Data tidak tersedia' }}</td>
                                </tr>
                                <tr>
                                    <th>Buku</th>
                                    <td>{{ $denda->peminjaman->buku->judul_buku ?? 'Data tidak tersedia' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pinjam</th>
                                    <td>{{ date('d-m-Y', strtotime($denda->peminjaman->tanggal_peminjaman)) }}</td>
                                </tr>
                                <tr>
                                    <th>Batas Pengembalian</th>
                                    <td>{{ date('d-m-Y', strtotime($denda->peminjaman->tanggal_pengembalian)) }}</td>
                                </tr>
                                <tr>
                                    <th>Status Peminjaman</th>
                                    <td>
                                        @if($denda->peminjaman->status_peminjaman == 'dipinjam')
                                            <span class="badge bg-primary">Dipinjam</span>
                                        @elseif($denda->peminjaman->status_peminjaman == 'terlambat')
                                            <span class="badge bg-danger">Terlambat</span>
                                        @elseif($denda->peminjaman->status_peminjaman == 'dikembalikan')
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $denda->peminjaman->status_peminjaman }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2">Informasi Denda</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th style="width: 30%">ID Denda</th>
                                    <td>{{ $denda->id_denda }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Denda Per Hari</th>
                                    <td>Rp {{ number_format($denda->jumlah_denda_perhari, 0, ',', '.') }}</td>
                                </tr>
                                @if($denda->denda_hilang > 0)
                                <tr>
                                    <th>Denda Hilang/Rusak</th>
                                    <td>Rp {{ number_format($denda->denda_hilang, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Total Denda</th>
                                    <td class="fw-bold">Rp {{ number_format($denda->total_denda_keseluruhan, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Status Pembayaran</th>
                                    <td>
                                        @if($denda->status_pembayaran == 'lunas')
                                            <span class="badge bg-success">Lunas</span>
                                        @else
                                            <span class="badge bg-danger">Belum Lunas</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($denda->tanggal_pembayaran)
                                <tr>
                                    <th>Tanggal Pembayaran</th>
                                    <td>{{ date('d-m-Y', strtotime($denda->tanggal_pembayaran)) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Dibuat Pada</th>
                                    <td>{{ date('d-m-Y H:i', strtotime($denda->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <th>Diperbarui Pada</th>
                                    <td>{{ date('d-m-Y H:i', strtotime($denda->updated_at)) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('denda.index') }}" class="btn btn-secondary">Kembali</a>
                        <div>
                            @if($denda->status_pembayaran == 'belum_lunas')
                                <form action="{{ route('denda.payFine', $denda->id_denda) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-money-bill"></i> Bayar Denda
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('denda.edit', $denda->id_denda) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('denda.destroy', $denda->id_denda) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data denda ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection