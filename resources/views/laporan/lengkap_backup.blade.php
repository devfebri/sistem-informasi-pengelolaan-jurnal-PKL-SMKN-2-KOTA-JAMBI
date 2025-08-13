@extends('layouts.master')
@section('title', 'Laporan Lengkap PKL')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-bar-chart"></i>
        Laporan Lengkap PKL
        <small>Data Komprehensif SMKN 2 Kota Jambi</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('laporan.index') }}">Laporan</a></li>
        <li class="active">Laporan Lengkap</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Filter Box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-filter"></i> Filter Laporan</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('laporan.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('laporan.lengkap', array_merge(request()->all(), ['download' => 'pdf'])) }}" 
                   class="btn btn-danger btn-sm">
                    <i class="fa fa-file-pdf-o"></i> Download PDF
                </a>
            </div>
        </div>
        <div class="box-body">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('laporan.lengkap') }}" class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Mulai:</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" 
                               class="form-control" value="{{ $tanggalMulai }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal_selesai">Tanggal Selesai:</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" 
                               class="form-control" value="{{ $tanggalSelesai }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
                    </button>
                </div>
    
    <!-- Statistik Umum -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalJurnal }}</h3>
                    <p>Total Jurnal</p>
                </div>
                <div class="icon">
                    <i class="fa fa-book"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalSiswa }}</h3>
                    <p>Total Siswa</p>
                </div>
                <div class="icon">
                    <i class="fa fa-graduation-cap"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalGuru }}</h3>
                    <p>Total Guru</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalInstansi }}</h3>
                    <p>Total Instansi</p>
                </div>
                <div class="icon">
                    <i class="fa fa-building-o"></i>
                </div>
            </div>
        </div>
    </div><!-- Status Validasi Jurnal -->
<div class="row">
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Status Validasi Jurnal</h3>
            </div>
            <div class="box-body">
                <canvas id="statusChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Detail Status</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-6">
                        <div class="info-box bg-green">
                            <span class="info-box-icon"><i class="fa fa-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Valid</span>
                                <span class="info-box-number">{{ $jurnalValid }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="info-box bg-yellow">
                            <span class="info-box-icon"><i class="fa fa-edit"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Revisi</span>
                                <span class="info-box-number">{{ $jurnalRevisi }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="info-box bg-red">
                            <span class="info-box-icon"><i class="fa fa-times"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Tidak Valid</span>
                                <span class="info-box-number">{{ $jurnalTidakValid }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="info-box bg-gray">
                            <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Belum Validasi</span>
                                <span class="info-box-number">{{ $jurnalBelumValidasi }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Jurnal Per Instansi -->
<div class="row">
    <div class="col-md-6">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Jurnal Per Instansi</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Instansi</th>
                                <th>Jumlah Jurnal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jurnalPerInstansi as $instansi => $jumlah)
                                <tr>
                                    <td>{{ $instansi }}</td>
                                    <td>{{ $jumlah }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Jurnal Per Guru Pembimbing</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Guru Pembimbing</th>
                                <th>Jumlah Jurnal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jurnalPerGuru as $guru => $jumlah)
                                <tr>
                                    <td>{{ $guru }}</td>
                                    <td>{{ $jumlah }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Penilaian Berkala Terbaru -->
<div class="row">
    <div class="col-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Penilaian Berkala Terbaru ({{ $totalPenilaian }} Total)</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th>Guru Penilai</th>
                                <th>Periode</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penilaianBerkala->take(10) as $penilaian)
                                <tr>
                                    <td>{{ is_object($penilaian->tanggal_penilaian) ? $penilaian->tanggal_penilaian->format('d/m/Y') : date('d/m/Y', strtotime($penilaian->tanggal_penilaian)) }}</td>
                                    <td>{{ $penilaian->siswa->name ?? 'N/A' }}</td>
                                    <td>{{ $penilaian->guru->name ?? 'N/A' }}</td>
                                    <td>{{ $penilaian->periode_penilaian }}</td>
                                    <td>
                                        <span class="label label-{{ $penilaian->nilai >= 80 ? 'success' : ($penilaian->nilai >= 70 ? 'warning' : 'danger') }}">
                                            {{ $penilaian->nilai }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data penilaian</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Jurnal Terbaru -->
<div class="row">
    <div class="col-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Jurnal Terbaru</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th>Instansi</th>
                                <th>Kegiatan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jurnalTerbaru->take(15) as $jurnal)
                                <tr>
                                    <td>{{ is_object($jurnal->tanggal) ? $jurnal->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($jurnal->tanggal)) }}</td>
                                    <td>{{ $jurnal->siswa->name ?? 'N/A' }}</td>
                                    <td>{{ $jurnal->siswa->instansi->nama ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($jurnal->deskripsi, 50) }}</td>
                                    <td>
                                        @php
                                            $status = $jurnal->penilaian->first()?->status_validasi ?? 'belum_validasi';
                                        @endphp
                                        <span class="label label-{{ 
                                            $status == 'valid' ? 'success' : 
                                            ($status == 'revisi' ? 'warning' : 
                                            ($status == 'tidak_valid' ? 'danger' : 'default')) 
                                        }}">
                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data jurnal</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('statusChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Valid', 'Revisi', 'Tidak Valid', 'Belum Validasi'],
            datasets: [{
                data: [{{ $jurnalValid }}, {{ $jurnalRevisi }}, {{ $jurnalTidakValid }}, {{ $jurnalBelumValidasi }}],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#6c757d']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endpush

</section>
<!-- /.content -->
@endsection
