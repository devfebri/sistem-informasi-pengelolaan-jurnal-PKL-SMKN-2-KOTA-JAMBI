@extends('layouts.master')
@section('title', 'Pusat Laporan PKL')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-file-text-o"></i>
        Pusat Laporan PKL
        <small>Sistem Informasi Pengelolaan Jurnal PKL SMKN 2 Kota Jambi</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Laporan</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    
    <!-- Info boxes -->
    <div class="row">
        <!-- Laporan Lengkap -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-bar-chart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Laporan Lengkap</span>
                    <span class="info-box-number">Komprehensif</span>
                    <div class="info-box-more">
                        <a href="{{ route('laporan.lengkap') }}" class="btn btn-primary btn-xs">
                            <i class="fa fa-eye"></i> Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laporan Per Siswa -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-graduation-cap"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Laporan Per Siswa</span>
                    <span class="info-box-number">Detail Siswa</span>
                    <div class="info-box-more">
                        <a href="{{ route('laporan.siswa') }}" class="btn btn-success btn-xs">
                            <i class="fa fa-eye"></i> Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laporan Per Instansi -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-building-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Laporan Per Instansi</span>
                    <span class="info-box-number">Per Instansi</span>
                    <div class="info-box-more">
                        <a href="{{ route('laporan.instansi') }}" class="btn btn-warning btn-xs">
                            <i class="fa fa-eye"></i> Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick PDF -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-file-pdf-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Download PDF</span>
                    <span class="info-box-number">Instant</span>
                    <div class="info-box-more">
                        <a href="{{ route('laporan.lengkap', ['download' => 'pdf']) }}" class="btn btn-danger btn-xs">
                            <i class="fa fa-download"></i> PDF Lengkap
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content box -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-info-circle"></i> Panduan Laporan
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="box box-solid box-info">
                                <div class="box-header">
                                    <h4 class="box-title">
                                        <i class="fa fa-bar-chart text-aqua"></i> Laporan Lengkap
                                    </h4>
                                </div>
                                <div class="box-body">
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-check-circle text-green"></i> Statistik jurnal keseluruhan</li>
                                        <li><i class="fa fa-check-circle text-green"></i> Data penilaian berkala</li>
                                        <li><i class="fa fa-check-circle text-green"></i> Rekapitulasi per instansi</li>
                                        <li><i class="fa fa-check-circle text-green"></i> Analisis per guru pembimbing</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box box-solid box-success">
                                <div class="box-header">
                                    <h4 class="box-title">
                                        <i class="fa fa-graduation-cap text-green"></i> Laporan Per Siswa
                                    </h4>
                                </div>
                                <div class="box-body">
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-check-circle text-green"></i> Riwayat jurnal harian</li>
                                        <li><i class="fa fa-check-circle text-green"></i> Status validasi jurnal</li>
                                        <li><i class="fa fa-check-circle text-green"></i> Nilai penilaian berkala</li>
                                        <li><i class="fa fa-check-circle text-green"></i> Progress pembelajaran</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box box-solid box-warning">
                                <div class="box-header">
                                    <h4 class="box-title">
                                        <i class="fa fa-building-o text-yellow"></i> Laporan Per Instansi
                                    </h4>
                                </div>
                                <div class="box-body">
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-check-circle text-green"></i> Daftar siswa per instansi</li>
                                        <li><i class="fa fa-check-circle text-green"></i> Aktivitas jurnal instansi</li>
                                        <li><i class="fa fa-check-circle text-green"></i> Performa siswa per instansi</li>
                                        <li><i class="fa fa-check-circle text-green"></i> Statistik validasi jurnal</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section>
<!-- /.content -->
@endsection
