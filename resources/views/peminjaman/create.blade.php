@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Tambah Peminjaman Buku</span>
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

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('peminjaman.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="id_buku">Buku <span class="text-danger">*</span></label>
                            <select class="form-control @error('id_buku') is-invalid @enderror" id="id_buku" name="id_buku" required>
                                <option value="">Pilih Buku</option>
                                @foreach($bukus as $buku)
                                    <option value="{{ $buku->id_buku }}" {{ old('id_buku') == $buku->id_buku ? 'selected' : '' }}>
                                        {{ $buku->judul_buku }} (Tersedia: {{ $buku->jumlah_buku_tersedia }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_buku')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="id_siswa">Siswa <span class="text-danger">*</span></label>
                            <select class="form-control @error('id_siswa') is-invalid @enderror" id="id_siswa" name="id_siswa" required>
                                <option value="">Pilih Siswa</option>
                                @foreach($siswas as $siswa)
                                    <option value="{{ $siswa->id_siswa }}" {{ old('id_siswa') == $siswa->id_siswa ? 'selected' : '' }}>
                                        {{ $siswa->nama_siswa }} ({{ $siswa->nisn_siswa }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_siswa')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="id_petugas">Petugas <span class="text-danger">*</span></label>
                            <select class="form-control @error('id_petugas') is-invalid @enderror" id="id_petugas" name="id_petugas" required>
                                <option value="">Pilih Petugas</option>
                                @foreach($petugass as $petugas)
                                    <option value="{{ $petugas->id_petugas }}" {{ old('id_petugas') == $petugas->id_petugas ? 'selected' : '' }}>
                                        {{ $petugas->nama_petugas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_petugas')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="tanggal_peminjaman">Tanggal Peminjaman <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_peminjaman') is-invalid @enderror" id="tanggal_peminjaman" name="tanggal_peminjaman" value="{{ old('tanggal_peminjaman', date('Y-m-d')) }}" required>
                            @error('tanggal_peminjaman')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="tanggal_pengembalian">Tanggal Pengembalian <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_pengembalian') is-invalid @enderror" id="tanggal_pengembalian" name="tanggal_pengembalian" value="{{ old('tanggal_pengembalian', date('Y-m-d', strtotime('+7 days'))) }}" required>
                            @error('tanggal_pengembalian')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection