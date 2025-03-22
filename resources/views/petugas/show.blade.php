@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Detail Petugas Perpustakaan</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th style="width: 30%">ID Petugas</th>
                            <td>{{ $petuga->id_petugas }}</td>
                        </tr>
                        <tr>
                            <th>Nama Petugas</th>
                            <td>{{ $petuga->nama_petugas }}</td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td>{{ $petuga->username_petugas }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $petuga->email_petugas }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Dibuat</th>
                            <td>{{ $petuga->created_at->format('d-m-Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diperbarui</th>
                            <td>{{ $petuga->updated_at->format('d-m-Y H:i:s') }}</td>
                        </tr>
                    </table>
                    
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('petugas.index') }}" class="btn btn-secondary">Kembali</a>
                        <div>
                            <a href="{{ route('petugas.edit', $petuga->id_petugas) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('petugas.destroy', $petuga->id_petugas) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus petugas ini?')">
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