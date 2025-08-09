@extends('layouts.master')

@section('title', 'Dashboard Guru')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard Guru</h1>
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
        <!-- Info boxes -->
        <div class="row">            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Siswa Bimbingan</span>
                        <span class="info-box-number">{{ $totalSiswaBimbingan }}</span>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fa fa-book"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Jurnal</span>
                        <span class="info-box-number">{{ $totalJurnalBimbingan }}</span>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-check-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Penilaian Berkala</span>
                        <span class="info-box-number">{{ $totalPenilaianBerkala }}</span>
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

        <!-- Status Validasi Jurnal -->
        <div class="row">
            <div class="col-lg-6">                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-pie-chart mr-1"></i>
                            Status Validasi Jurnal
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="statusChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Siswa Bimbingan -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-users mr-1"></i>
                            Siswa Bimbingan
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($siswaBimbingan->count() > 0)
                            <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>NISN</th>
                                            <th>Instansi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($siswaBimbingan as $siswa)
                                        <tr>
                                            <td>{{ $siswa->name }}</td>
                                            <td>{{ $siswa->nisn }}</td>
                                            <td>                                                @if($siswa->instansi)
                                                    {{ $siswa->instansi->nama }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted text-center">Belum ada siswa bimbingan</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Jurnal Terbaru -->
        <div class="row">
            <div class="col-12">                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-clock-o mr-1"></i>
                            Jurnal Terbaru Siswa Bimbingan
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
                                            <th>Siswa</th>
                                            <th>Kegiatan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentJurnals as $jurnal)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d/m/Y') }}</td>
                                            <td>{{ $jurnal->siswa_name }}</td>
                                            <td>{{ Str::limit($jurnal->kegiatan, 50) }}</td>
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
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted text-center">Belum ada jurnal dari siswa bimbingan</p>
                        @endif
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
                                <a href="{{ route('jurnal.index') }}" class="btn btn-block btn-outline-primary">
                                    <i class="fa fa-book"></i><br>
                                    Kelola Jurnal
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <a href="{{ route('penilaian-berkala.index') }}" class="btn btn-block btn-outline-success">
                                    <i class="fa fa-check-circle"></i><br>
                                    Penilaian Berkala
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <a href="{{ route('siswa.index') }}" class="btn btn-block btn-outline-info">
                                    <i class="fa fa-users"></i><br>
                                    Data Siswa
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <a href="{{ route('penilaian-berkala.create') }}" class="btn btn-block btn-outline-warning">
                                    <i class="fa fa-plus"></i><br>
                                    Buat Penilaian
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
});
</script>
@endpush
