@extends('layouts.app')

@section('title', 'Data Buku')

@section('action_buttons')
<a href="{{ route('buku.create') }}" class="btn btn-primary">
    <i class="fas fa-plus-circle me-1"></i>Tambah Buku
</a>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="bukuTable">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun Terbit</th>
                        <th>ISBN</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bukus as $index => $buku)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $buku->judul_buku }}</td>
                        <td>{{ $buku->penulis_buku }}</td>
                        <td>{{ $buku->penerbit_buku }}</td>
                        <td>{{ $buku->tahun_terbit }}</td>
                        <td>{{ $buku->isbn_buku }}</td>
                        <td>{{ $buku->kategori_buku }}</td>
                        <td>
                            @if($buku->jumlah_buku_tersedia > 0)
                                <span class="badge bg-success">{{ $buku->jumlah_buku_tersedia }}</span>
                            @else
                                <span class="badge bg-danger">Habis</span>
                            @endif
                        </td>
                        <td class="action-buttons">
                            <a href="{{ route('buku.show', $buku->id_buku) }}" class="btn btn-sm btn-info text-white">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('buku.edit', $buku->id_buku) }}" class="btn btn-sm btn-warning text-white">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('buku.destroy', $buku->id_buku) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#bukuTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
            }
        });
    });
</script>
@endsection