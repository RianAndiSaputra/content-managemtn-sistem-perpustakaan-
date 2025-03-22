@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit Petugas Perpustakaan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('petugas.update', $petuga->id_petugas) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="nama_petugas" class="form-label">Nama Petugas</label>
                            <input type="text" class="form-control @error('nama_petugas') is-invalid @enderror" id="nama_petugas" name="nama_petugas" value="{{ old('nama_petugas', $petuga->nama_petugas) }}" required>
                            @error('nama_petugas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="username_petugas" class="form-label">Username</label>
                            <input type="text" class="form-control @error('username_petugas') is-invalid @enderror" id="username_petugas" name="username_petugas" value="{{ old('username_petugas', $petuga->username_petugas) }}" required>
                            @error('username_petugas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email_petugas" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email_petugas') is-invalid @enderror" id="email_petugas" name="email_petugas" value="{{ old('email_petugas', $petuga->email_petugas) }}" required>
                            @error('email_petugas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_petugas" class="form-label">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control @error('password_petugas') is-invalid @enderror" id="password_petugas" name="password_petugas">
                            @error('password_petugas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('petugas.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection