@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="m-0">Daftar Denda</h5>
                        <div>
                            <a href="{{ route('denda.report') }}" class="btn btn-info btn-sm me-2">
                                <i class="fas fa-file-alt"></i> Laporan Denda
                            </a>
                            <a href="{{ route('denda.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah Denda
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Siswa</th>
                                    <th>Buku</th>
                                    <th>Total Denda</th>
                                    <th>Status</th>
                                    <th>Tgl. Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dendas as $index => $denda)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $denda->peminjaman->siswa->nama_siswa ?? 'Data tidak tersedia' }}</td>
                                        <td>{{ $denda->peminjaman->buku->judul_buku ?? 'Data tidak tersedia' }}</td>
                                        <td>Rp {{ number_format($denda->total_denda_keseluruhan, 0, ',', '.') }}</td>
                                        <td>
                                            @if($denda->status_pembayaran == 'lunas')
                                                <span class="badge bg-success">Lunas</span>
                                            @else
                                                <span class="badge bg-danger">Belum Lunas</span>
                                            @endif
                                        </td>
                                        <td>{{ $denda->tanggal_pembayaran ? date('d-m-Y', strtotime($denda->tanggal_pembayaran)) : '-' }}</td>
                                        <td>
                                            <a href="{{ route('denda.show', $denda->id_denda) }}" class="btn btn-info btn-sm" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('denda.edit', $denda->id_denda) }}" class="btn btn-primary btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($denda->status_pembayaran == 'belum_lunas')
                                                <form action="{{ route('denda.payFine', $denda->id_denda) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success btn-sm" title="Bayar Denda">
                                                        <i class="fas fa-money-bill"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('denda.destroy', $denda->id_denda) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data denda ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data denda</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection