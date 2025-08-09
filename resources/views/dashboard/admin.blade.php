@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-dashboard"></i> Dashboard Admin
        <small>Sistem Informasi PKL SMKN 2 Kota Jambi</small>
    </h1>
    <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
    </ol>
</section>

<section class="content">
    <!-- Statistik Utama -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $totalSiswa }}</h3>
                    <p>Total Siswa PKL</p>
                </div>                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="{{ route('siswa.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $totalGuru }}</h3>
                    <p>Total Guru Pembimbing</p>
                </div>                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="{{ route('guru.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $totalInstansi }}</h3>
                    <p>Instansi Mitra PKL</p>
                </div>
                <div class="icon">
                    <i class="fa fa-building"></i>
                </div>
                <a href="{{ route('instansi.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $totalJurnal }}</h3>
                    <p>Total Jurnal PKL</p>
                </div>
                <div class="icon">
                    <i class="fa fa-book"></i>
                </div>
                <a href="{{ route('jurnal.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistik Validasi Jurnal -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Jurnal Valid</span>
                    <span class="info-box-number">{{ $jurnalValid }}</span>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-edit"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Perlu Revisi</span>
                    <span class="info-box-number">{{ $jurnalRevisi }}</span>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-times"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Tidak Valid</span>
                    <span class="info-box-number">{{ $jurnalTidakValid }}</span>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
            <div class="info-box">
                <span class="info-box-icon bg-gray"><i class="fa fa-clock-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Menunggu Validasi</span>
                    <span class="info-box-number">{{ $jurnalMenunggu }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Chart Jurnal Bulanan -->
        <div class="col-md-8">                <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bar-chart"></i> Statistik Jurnal Bulanan</h3>
                </div>
                <div class="box-body">
                    <canvas id="monthlyChart" style="height:300px"></canvas>
                </div>
            </div>
        </div>

        <!-- Status Validasi Pie Chart -->
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-pie-chart"></i> Status Validasi</h3>
                </div>
                <div class="box-body">
                    <canvas id="statusChart" style="height:250px"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-clock-o"></i> Aktivitas Jurnal Terbaru</h3>
                </div>
                <div class="box-body">
                    @if($recentJurnals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Siswa</th>
                                        <th>Kegiatan</th>
                                        <th>Status</th>
                                        <th>Waktu Dibuat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentJurnals as $jurnal)
                                    <tr>
                                        <td>
                                            <span class="label label-info">
                                                {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td><strong>{{ $jurnal->siswa_name }}</strong></td>
                                        <td>{{ Str::limit($jurnal->kegiatan, 50) }}</td>
                                        <td>
                                            @if($jurnal->status_validasi)
                                                @if($jurnal->status_validasi == 'valid')
                                                    <span class="label label-success">Valid</span>
                                                @elseif($jurnal->status_validasi == 'revisi')
                                                    <span class="label label-warning">Revisi</span>
                                                @else
                                                    <span class="label label-danger">Tidak Valid</span>
                                                @endif
                                            @else
                                                <span class="label label-default">Menunggu</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($jurnal->created_at)->diffForHumans() }}
                                            </small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Belum ada aktivitas jurnal.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: [
                @foreach($monthlyJurnals as $data)
                    '{{ $data["month"] }}',
                @endforeach
            ],
            datasets: [{
                label: 'Jurnal PKL',
                data: [
                    @foreach($monthlyJurnals as $data)
                        {{ $data["count"] }},
                    @endforeach
                ],
                borderColor: 'rgb(60, 141, 188)',
                backgroundColor: 'rgba(60, 141, 188, 0.1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Trend Jurnal PKL (6 Bulan Terakhir)'
                }
            }
        }
    });

    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Valid', 'Revisi', 'Tidak Valid', 'Menunggu'],
            datasets: [{
                data: [{{ $jurnalValid }}, {{ $jurnalRevisi }}, {{ $jurnalTidakValid }}, {{ $jurnalMenunggu }}],
                backgroundColor: [
                    '#00a65a',
                    '#f39c12',
                    '#dd4b39',
                    '#d2d6de'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush
