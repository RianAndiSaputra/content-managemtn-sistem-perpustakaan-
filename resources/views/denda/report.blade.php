@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Laporan Denda</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('denda.report') }}" method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                                <select class="form-select" id="status_pembayaran" name="status_pembayaran">
                                    <option value="">Semua</option>
                                    <option value="lunas" {{ request('status_pembayaran') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                    <option value="belum_lunas" {{ request('status_pembayaran') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="tanggal_mulai" class="form-label">Dari Tanggal</label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="tanggal_akhir" class="form-label">Sampai Tanggal</label>
                                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="member" class="form-label">Member</label>
                                <input type="text" class="form-control" id="member" name="member" value="{{ request('member') }}" placeholder="Nama member">
                            </div>
                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('denda.report') }}" class="btn btn-secondary">Reset</a>
                                <a href="{{ route('denda.export') }}?{{ http_build_query(request()->all()) }}" class="btn btn-success float-end">
                                    <i class="bi bi-download"></i> Export Excel
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Denda</th>
                                    <th>Nama Member</th>
                                    <th>Tanggal Denda</th>
                                    <th>Jumlah Hari</th>
                                    <th>Total Denda</th>
                                    <th>Status</th>
                                    <th>Tanggal Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dendas as $index => $denda)
                                <tr>
                                    <td>{{ $index + $dendas->firstItem() }}</td>
                                    <td>{{ $denda->kode_denda }}</td>
                                    <td>{{ $denda->peminjaman->member->nama }}</td>
                                    <td>{{ $denda->tanggal_denda->format('d-m-Y') }}</td>
                                    <td>{{ $denda->jumlah_hari }}</td>
                                    <td>Rp {{ number_format($denda->total_denda, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $denda->status_pembayaran == 'lunas' ? 'success' : 'danger' }}">
                                            {{ $denda->status_pembayaran == 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                                        </span>
                                    </td>
                                    <td>{{ $denda->tanggal_pembayaran ? $denda->tanggal_pembayaran->format('d-m-Y') : '-' }}</td>
                                    <td>
                                        <a href="{{ route('denda.show', $denda->id) }}" class="btn btn-sm btn-info">Detail</a>
                                        @if($denda->status_pembayaran == 'belum_lunas')
                                        <a href="{{ route('denda.edit', $denda->id) }}" class="btn btn-sm btn-warning">Bayar</a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data denda</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $dendas->appends(request()->all())->links() }}
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">Ringkasan</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Total Denda:</strong> Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
                                    <p><strong>Total Denda Lunas:</strong> Rp {{ number_format($totalDendaLunas, 0, ',', '.') }}</p>
                                    <p><strong>Total Denda Belum Lunas:</strong> Rp {{ number_format($totalDendaBelumLunas, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection