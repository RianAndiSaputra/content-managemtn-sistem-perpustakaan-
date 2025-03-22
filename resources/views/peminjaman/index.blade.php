@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Daftar Peminjaman</span>
                    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Peminjaman
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Buku</th>
                                    <th>Siswa</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($peminjamans as $key => $peminjaman)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $peminjaman->buku->judul_buku }}</td>
                                        <td>{{ $peminjaman->siswa->nama_siswa }}</td>
                                        <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d-m-Y') }}</td>
                                        <td>
                                            @if($peminjaman->status_peminjaman == 'dipinjam')
                                                <span class="badge bg-info">Dipinjam</span>
                                            @elseif($peminjaman->status_peminjaman == 'dikembalikan')
                                                <span class="badge bg-success">Dikembalikan</span>
                                            @elseif($peminjaman->status_peminjaman == 'terlambat')
                                                <span class="badge bg-danger">Terlambat</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('peminjaman.show', $peminjaman->id_peminjaman) }}" class="btn btn-info btn-sm mr-1">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                                <a href="{{ route('peminjaman.edit', $peminjaman->id_peminjaman) }}" class="btn btn-warning btn-sm mr-1">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('peminjaman.destroy', $peminjaman->id_peminjaman) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data peminjaman ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data peminjaman</td>
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