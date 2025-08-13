@extends('layouts.master')
@section('title', 'Laporan Per Siswa')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="card-title">
                                <i class="fas fa-user-graduate mr-2"></i>
                                Laporan Per Siswa
                            </h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('laporan.index') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left mr-1"></i>Kembali
                            </a>
                            @if($siswa)
                                <a href="{{ route('laporan.siswa', array_merge(request()->all(), ['download' => 'pdf'])) }}" 
                                   class="btn btn-danger">
                                    <i class="fas fa-file-pdf mr-1"></i>Download PDF
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('laporan.siswa') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="siswa_id">Pilih Siswa</label>
                                <select name="siswa_id" id="siswa_id" class="form-control" required>
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach($siswaList as $s)
                                        <option value="{{ $s->id }}" {{ request('siswa_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->name }} - {{ $s->nisn }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="tanggal_mulai">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" 
                                       class="form-control" value="{{ $tanggalMulai }}">
                            </div>
                            <div class="col-md-3">
                                <label for="tanggal_selesai">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" 
                                       class="form-control" value="{{ $tanggalSelesai }}">
                            </div>
                            <div class="col-md-3">
                                <label>&nbsp;</label><br>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search mr-1"></i>Lihat Laporan
                                </button>
                            </div>
                        </div>
                    </form>

                    @if($siswa)
                        <!-- Informasi Siswa -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h4>Informasi Siswa</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td width="30%"><strong>Nama:</strong></td>
                                                        <td>{{ $siswa->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>NISN:</strong></td>
                                                        <td>{{ $siswa->nisn }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Email:</strong></td>
                                                        <td>{{ $siswa->email }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td width="30%"><strong>Instansi:</strong></td>
                                                        <td>{{ $siswa->instansi->nama ?? 'Belum ditentukan' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Guru Pembimbing:</strong></td>
                                                        <td>{{ $siswa->guru->name ?? 'Belum ditentukan' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>No. Telepon:</strong></td>
                                                        <td>{{ $siswa->phone ?? '-' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistik Siswa -->
                        <div class="row mb-4">
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{ $statistik['total_jurnal'] }}</h3>
                                        <p>Total Jurnal</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-book"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{ $statistik['jurnal_valid'] }}</h3>
                                        <p>Jurnal Valid</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>{{ $statistik['jurnal_revisi'] }}</h3>
                                        <p>Perlu Revisi</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>{{ number_format($statistik['nilai_rata_rata'], 1) }}</h3>
                                        <p>Rata-rata Nilai</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Penilaian Berkala -->
                        @if($penilaians->count() > 0)
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Riwayat Penilaian Berkala</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Guru Penilai</th>
                                                        <th>Periode</th>
                                                        <th>Nilai</th>
                                                        <th>Catatan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($penilaians as $penilaian)
                                                        <tr>
                                                            <td>{{ is_object($penilaian->tanggal_penilaian) ? $penilaian->tanggal_penilaian->format('d/m/Y') : date('d/m/Y', strtotime($penilaian->tanggal_penilaian)) }}</td>
                                                            <td>{{ $penilaian->guru->name ?? 'N/A' }}</td>
                                                            <td>{{ $penilaian->periode_penilaian }}</td>
                                                            <td>
                                                                <span class="badge badge-{{ $penilaian->nilai >= 80 ? 'success' : ($penilaian->nilai >= 70 ? 'warning' : 'danger') }}">
                                                                    {{ $penilaian->nilai }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $penilaian->catatan ?? '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Riwayat Jurnal -->
                        @if($jurnals->count() > 0)
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Riwayat Jurnal Harian</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="12%">Tanggal</th>
                                                        <th width="40%">Kegiatan</th>
                                                        <th width="20%">Waktu</th>
                                                        <th width="15%">Status</th>
                                                        <th width="13%">Catatan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($jurnals as $jurnal)
                                                        <tr>
                                                            <td>{{ is_object($jurnal->tanggal) ? $jurnal->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($jurnal->tanggal)) }}</td>
                                                            <td>{{ $jurnal->deskripsi }}</td>
                                                            <td>{{ $jurnal->waktu_mulai }} - {{ $jurnal->waktu_selesai }}</td>
                                                            <td>
                                                                @php
                                                                    $status = $jurnal->penilaian->first()?->status_validasi ?? 'belum_validasi';
                                                                @endphp
                                                                <span class="badge badge-{{ 
                                                                    $status == 'valid' ? 'success' : 
                                                                    ($status == 'revisi' ? 'warning' : 
                                                                    ($status == 'tidak_valid' ? 'danger' : 'secondary')) 
                                                                }}">
                                                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $jurnal->penilaian->first()?->catatan ?? '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($jurnals->count() == 0 && $penilaians->count() == 0)
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Tidak ada data jurnal atau penilaian untuk siswa ini dalam periode yang dipilih.
                                </div>
                            </div>
                        </div>
                        @endif

                    @else
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    Silakan pilih siswa terlebih dahulu untuk melihat laporan.
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
