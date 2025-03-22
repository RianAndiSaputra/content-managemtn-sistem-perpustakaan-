@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Edit Status Peminjaman</span>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <h5>Informasi Peminjaman:</h5>
                        <p>
                            <strong>Buku:</strong> {{ $peminjaman->buku->judul_buku }}<br>
                            <strong>Siswa:</strong> {{ $peminjaman->siswa->nama_siswa }}<br>
                            <strong>Tanggal Peminjaman:</strong> {{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d-m-Y') }}<br>
                            <strong>Tanggal Pengembalian:</strong> {{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d-m-Y') }}
                        </p>
                    </div>

                    <form action="{{ route('peminjaman.update', $peminjaman->id_peminjaman) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label for="status_peminjaman">Status Peminjaman <span class="text-danger">*</span></label>
                            <select class="form-control @error('status_peminjaman') is-invalid @enderror" id="status_peminjaman" name="status_peminjaman" required>
                                <option value="dipinjam" {{ old('status_peminjaman', $peminjaman->status_peminjaman) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="dikembalikan" {{ old('status_peminjaman', $peminjaman->status_peminjaman) == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                <option value="terlambat" {{ old('status_peminjaman', $peminjaman->status_peminjaman) == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                            </select>
                            @error('status_peminjaman')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Perhatian:
                            <ul>
                                <li>Mengubah status dari "Dipinjam" ke "Dikembalikan" akan menambah stok buku.</li>
                                <li>Jika tanggal pengembalian sudah terlewat, sistem akan otomatis menghitung denda.</li>
                            </ul>
                        </div>

                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Perbarui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection