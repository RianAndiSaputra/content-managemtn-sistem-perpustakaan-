@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Tambah Siswa Baru</span>
                    <a href="{{ route('siswa.index') }}" class="btn btn-secondary btn-sm">
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

                    <form action="{{ route('siswa.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="nisn_siswa">NISN <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nisn_siswa') is-invalid @enderror" id="nisn_siswa" name="nisn_siswa" value="{{ old('nisn_siswa') }}" required>
                            @error('nisn_siswa')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama_siswa">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa') }}" required>
                            @error('nama_siswa')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="kelas">Kelas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas" name="kelas" value="{{ old('kelas') }}" required>
                            @error('kelas')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat_siswa">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat_siswa') is-invalid @enderror" id="alamat_siswa" name="alamat_siswa" rows="3" required>{{ old('alamat_siswa') }}</textarea>
                            @error('alamat_siswa')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="nomor_telepon">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}" required>
                            @error('nomor_telepon')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email_siswa">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email_siswa') is-invalid @enderror" id="email_siswa" name="email_siswa" value="{{ old('email_siswa') }}" required>
                            @error('email_siswa')
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