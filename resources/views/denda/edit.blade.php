@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit Denda</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('denda.update', $denda->id_denda) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="id_peminjaman" class="form-label">Peminjaman</label>
                            <select class="form-select @error('id_peminjaman') is-invalid @enderror" id="id_peminjaman" name="id_peminjaman" required>
                                <option value="">-- Pilih Peminjaman --</option>
                                @foreach($peminjamans as $peminjaman)
                                    <option value="{{ $peminjaman->id_peminjaman }}" {{ old('id_peminjaman', $denda->id_peminjaman) == $peminjaman->id_peminjaman ? 'selected' : '' }}>
                                        {{ $peminjaman->siswa->nama_siswa ?? 'Tidak ada nama' }} - 
                                        {{ $peminjaman->buku->judul_buku ?? 'Tidak ada judul' }} - 
                                        (Tgl. Kembali: {{ date('d-m-Y', strtotime($peminjaman->tanggal_pengembalian)) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_peminjaman')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="jumlah_denda_perhari" class="form-label">Jumlah Denda Per Hari (Rp)</label>
                            <input type="number" class="form-control @error('jumlah_denda_perhari') is-invalid @enderror" id="jumlah_denda_perhari" name="jumlah_denda_perhari" value="{{ old('jumlah_denda_perhari', $denda->jumlah_denda_perhari) }}" required>
                            @error('jumlah_denda_perhari')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="denda_hilang" class="form-label">Denda Buku Hilang/Rusak (Rp)</label>
                            <input type="number" class="form-control @error('denda_hilang') is-invalid @enderror" id="denda_hilang" name="denda_hilang" value="{{ old('denda_hilang', $denda->denda_hilang) }}">
                            @error('denda_hilang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="total_denda_keseluruhan" class="form-label">Total Denda Keseluruhan (Rp)</label>
                            <input type="number" class="form-control @error('total_denda_keseluruhan') is-invalid @enderror" id="total_denda_keseluruhan" name="total_denda_keseluruhan" value="{{ old('total_denda_keseluruhan', $denda->total_denda_keseluruhan) }}" required>
                            @error('total_denda_keseluruhan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                            <select class="form-select @error('status_pembayaran') is-invalid @enderror" id="status_pembayaran" name="status_pembayaran" required>
                                <option value="belum_lunas" {{ old('status_pembayaran', $denda->status_pembayaran) == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                <option value="lunas" {{ old('status_pembayaran', $denda->status_pembayaran) == 'lunas' ? 'selected' : '' }}>Lunas</option>
                            </select>
                            @error('status_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3" id="tanggal_pembayaran_container">
                            <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
                            <input type="date" class="form-control @error('tanggal_pembayaran') is-invalid @enderror" id="tanggal_pembayaran" name="tanggal_pembayaran" value="{{ old('tanggal_pembayaran', $denda->tanggal_pembayaran) }}">
                            @error('tanggal_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('denda.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="button" id="hitungDenda" class="btn btn-info">Hitung Ulang Denda</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle tanggal pembayaran berdasarkan status
        const statusPembayaran = document.getElementById('status_pembayaran');
        const tanggalPembayaranContainer = document.getElementById('tanggal_pembayaran_container');
        
        function toggleTanggalPembayaran() {
            if (statusPembayaran.value === 'lunas') {
                tanggalPembayaranContainer.style.display = 'block';
                document.getElementById('tanggal_pembayaran').required = true;
            } else {
                tanggalPembayaranContainer.style.display = 'none';
                document.getElementById('tanggal_pembayaran').required = false;
            }
        }
        
        toggleTanggalPembayaran();
        statusPembayaran.addEventListener('change', toggleTanggalPembayaran);
        
        // Hitung denda otomatis
        document.getElementById('hitungDenda').addEventListener('click', function() {
            const idPeminjaman = document.getElementById('id_peminjaman').value;
            const dendaPerhari = document.getElementById('jumlah_denda_perhari').value;
            const dendaHilang = document.getElementById('denda_hilang').value || 0;
            
            if (!idPeminjaman) {
                alert('Silakan pilih peminjaman terlebih dahulu');
                return;
            }
            
            fetch(`{{ url('denda/calculate-late-fee') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id_peminjaman: idPeminjaman,
                    jumlah_denda_perhari: dendaPerhari,
                    denda_hilang: dendaHilang
                })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('total_denda_keseluruhan').value = data.total_denda;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghitung denda');
            });
        });
    });
</script>
@endpush
@endsection