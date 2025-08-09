@extends('layouts.master')

@section('title', 'Dashboard Siswa')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard Siswa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fa fa-book"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Jurnal</span>
                        <span class="info-box-number">{{ $totalJurnal }}</span>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Jurnal Valid</span>
                        <span class="info-box-number">{{ $jurnalValid }}</span>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-edit"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Jurnal Revisi</span>
                        <span class="info-box-number">{{ $jurnalRevisi }}</span>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-clock-o"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Menunggu Validasi</span>
                        <span class="info-box-number">{{ $jurnalMenunggu }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <!-- Status Jurnal Chart -->
            <div class="col-lg-6">                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-pie-chart mr-1"></i>
                            Status Jurnal Saya
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="statusChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Progress Mingguan -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-line-chart mr-1"></i>
                            Progress Jurnal Mingguan
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="progressChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Content Row -->
        <div class="row">
            <!-- Jurnal Terbaru -->
            <div class="col-lg-8">                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-clock-o mr-1"></i>
                            Jurnal Terbaru Saya
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('jurnal.index') }}" class="btn btn-tool">
                                <i class="fa fa-external-link"></i> Lihat Semua
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($recentJurnals->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Kegiatan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentJurnals as $jurnal)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d/m/Y') }}</td>
                                            <td>{{ Str::limit($jurnal->kegiatan, 40) }}</td>
                                            <td>
                                                @if($jurnal->status_validasi == 'valid')
                                                    <span class="badge badge-success">Valid</span>
                                                @elseif($jurnal->status_validasi == 'revisi')
                                                    <span class="badge badge-warning">Revisi</span>
                                                @elseif($jurnal->status_validasi == 'tidak_valid')
                                                    <span class="badge badge-danger">Tidak Valid</span>
                                                @else
                                                    <span class="badge badge-secondary">Menunggu</span>
                                                @endif
                                            </td>                                            <td>
                                                <a href="{{ route('jurnal.show', $jurnal->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if($jurnal->status_validasi == 'revisi' || is_null($jurnal->status_validasi))
                                                    <a href="{{ route('jurnal.edit', $jurnal->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else                            <div class="text-center">
                                <p class="text-muted">Belum ada jurnal</p>
                                <a href="{{ route('jurnal.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Buat Jurnal Pertama
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Penilaian Berkala -->
            <div class="col-lg-4">                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-star mr-1"></i>
                            Penilaian Berkala Terbaru
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('penilaian-berkala.index') }}" class="btn btn-tool">
                                <i class="fa fa-external-link"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($penilaianBerkala->count() > 0)
                            @foreach($penilaianBerkala as $penilaian)
                                <div class="callout callout-info">
                                    <h5>Nilai: {{ $penilaian->nilai }}/100</h5>                                    <p class="text-sm">
                                        <i class="fa fa-calendar"></i> 
                                        {{ \Carbon\Carbon::parse($penilaian->tanggal_penilaian)->format('d/m/Y') }}
                                    </p>
                                    @if($penilaian->catatan)
                                        <p class="text-sm text-muted">
                                            <i class="fa fa-comment"></i>
                                            {{ Str::limit($penilaian->catatan, 50) }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted text-center">Belum ada penilaian berkala</p>
                        @endif
                    </div>
                </div>

                <!-- Informasi Siswa -->                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-user mr-1"></i>
                            Informasi Saya
                        </h3>
                    </div>
                    <div class="card-body">
                        <strong><i class="fa fa-id-card mr-1"></i> NISN</strong>
                        <p class="text-muted">{{ Auth::user()->nisn ?? '-' }}</p>
                        <hr>

                        <strong><i class="fa fa-user-md mr-1"></i> Guru Pembimbing</strong>
                        <p class="text-muted">
                            @if(Auth::user()->guru)
                                {{ Auth::user()->guru->name }}
                            @else
                                Belum ditentukan
                            @endif
                        </p>
                        <hr>                        <strong><i class="fa fa-building mr-1"></i> Instansi PKL</strong>
                        <p class="text-muted">
                            @if(Auth::user()->instansi)
                                {{ Auth::user()->instansi->nama }}
                            @else
                                Belum ditentukan
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-flash mr-1"></i>
                            Aksi Cepat
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-12">
                                <a href="{{ route('jurnal.create') }}" class="btn btn-block btn-primary">
                                    <i class="fa fa-plus"></i><br>
                                    Buat Jurnal Baru
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <a href="{{ route('jurnal.index') }}" class="btn btn-block btn-outline-info">
                                    <i class="fa fa-book"></i><br>
                                    Lihat Semua Jurnal
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <a href="{{ route('penilaian-berkala.index') }}" class="btn btn-block btn-outline-success">
                                    <i class="fa fa-star"></i><br>
                                    Lihat Penilaian
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <a href="#" class="btn btn-block btn-outline-warning" onclick="window.print()">
                                    <i class="fa fa-print"></i><br>
                                    Cetak Laporan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(function () {
    // Status Chart
    var statusData = {
        labels: ['Valid', 'Revisi', 'Tidak Valid', 'Menunggu'],
        datasets: [{
            data: [{{ $jurnalValid }}, {{ $jurnalRevisi }}, {{ $jurnalTidakValid }}, {{ $jurnalMenunggu }}],
            backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#6c757d'],
        }]
    };

    var statusOptions = {
        maintainAspectRatio: false,
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    };

    var statusCanvas = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCanvas, {
        type: 'doughnut',
        data: statusData,
        options: statusOptions
    });

    // Progress Chart
    var progressData = {
        labels: [
            @foreach($weeklyProgress as $progress)
                '{{ $progress["week"] }}',
            @endforeach
        ],
        datasets: [{
            label: 'Jurnal',
            data: [
                @foreach($weeklyProgress as $progress)
                    {{ $progress["count"] }},
                @endforeach
            ],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            fill: true
        }]
    };

    var progressOptions = {
        maintainAspectRatio: false,
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    };

    var progressCanvas = document.getElementById('progressChart').getContext('2d');
    new Chart(progressCanvas, {
        type: 'line',
        data: progressData,
        options: progressOptions
    });
});
</script>
@endpush
