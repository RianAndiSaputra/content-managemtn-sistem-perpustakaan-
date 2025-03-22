@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Detail Siswa</span>
                    <div>
                        <a href="{{ route('siswa.edit', $siswa->id_siswa) }}" class="btn btn-warning btn-sm mx-1">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">NISN</th>
                            <td>{{ $siswa->nisn_siswa }}</td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>{{ $siswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $siswa->kelas }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $siswa->alamat_siswa }}</td>
                        </tr>
                        <tr>
                            <th>Nomor Telepon</th>
                            <td>{{ $siswa->nomor_telepon }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $siswa->email_siswa }}</td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <form action="{{ route('siswa.destroy', $siswa->id_siswa) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
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