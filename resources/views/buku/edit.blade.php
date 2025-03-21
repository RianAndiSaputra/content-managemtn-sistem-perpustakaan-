@extends('layouts.app')

@section('title', 'Edit Buku')

@section('action_buttons')
<a href="{{ route('buku.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-1"></i>Kembali
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('buku.update', $buku->id_buku) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="judul_buku" class="form-label">Judul Buku <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul_buku') is-invalid @enderror" id="judul_buku" name="judul_buku" value="{{ old('judul_buku', $buku->judul_buku) }}" required>
                            @error('judul_buku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="isbn_buku" class="form-label">ISBN <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('isbn_buku') is-invalid @enderror" id="isbn_buku" name="isbn_buku" value="{{ old('isbn_buku', $buku->isbn_buku) }}" required>
                            @error('isbn_buku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="penulis_buku" class="form-label">Penulis <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('penulis_buku') is-invalid @enderror" id="penulis_buku" name="penulis_buku" value="{{ old('penulis_buku', $buku->penulis_buku) }}" required>
                            @error('penulis_buku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="penerbit_buku" class="form-label">Penerbit <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('penerbit_buku') is-invalid @enderror" id="penerbit_buku" name="penerbit_buku" value="{{ old('penerbit_buku', $buku->penerbit_buku) }}" required>
                            @error('penerbit_buku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="tahun_terbit" class="form-label">Tahun Terbit <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('tahun_terbit') is-invalid @enderror" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" min="1900" max="{{ date('Y') }}" required>
                            @error('tahun_terbit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="kategori_buku" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('kategori_buku') is-invalid @enderror" id="kategori_buku" name="kategori_buku" required>
                                <option value="" disabled>Pilih Kategori</option>
                                <option value="Fiksi" {{ old('kategori_buku', $buku->kategori_buku) == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                                <option value="Non-Fiksi" {{ old('kategori_buku', $buku->kategori_buku) == 'Non-Fiksi' ? 'selected' : '' }}>Non-Fiksi</option>
                                <option value="Referensi" {{ old('kategori_buku', $buku->kategori_buku) == 'Referensi' ? 'selected' : '' }}>Referensi</option>
                                <option value="Pelajaran" {{ old('kategori_buku', $buku->kategori_buku) == 'Pelajaran' ? 'selected' : ''