@extends('layouts.master')
@section('title', 'Laporan Per Instansi')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-building-o"></i>
        Laporan Per Instansi
        <small>Detail Aktivitas PKL Per Instansi</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('laporan.index') }}">Laporan</a></li>
        <li class="active">Laporan Per Instansi</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Filter Box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-filter"></i> Filter Laporan Instansi</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('laporan.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
                @if($instansi)
                    <a href="{{ route('laporan.instansi', array_merge(request()->all(), ['download' => 'pdf'])) }}" 
                       class="btn btn-danger btn-sm">
                        <i class="fa fa-file-pdf-o"></i> Download PDF
                    </a>
                @endif
            </div>
        </div>
        <div class="box-body">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('laporan.instansi') }}" class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="instansi_id">Pilih Instansi:</label>
                        <select name="instansi_id" id="instansi_id" class="form-control" required>
                            <option value="">-- Pilih Instansi --</option>
                            @foreach($instansiList as $inst)
                                <option value="{{ $inst->id }}" {{ request('instansi_id') == $inst->id ? 'selected' : '' }}>
                                    {{ $inst->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Mulai:</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" 
                               class="form-control" value="{{ $tanggalMulai }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tanggal_selesai">Tanggal Selesai:</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" 
                               class="form-control" value="{{ $tanggalSelesai }}">
                    </div>
                </div>
                <div class="col-md-3">
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

    @if($instansi)
        <!-- Informasi Instansi -->
        <div class="row">
            <div class="col-md-6">
                <div class="box box-widget widget-user">
                    <div class="widget-user-header bg-yellow">
                        <h3 class="widget-user-username">{{ $instansi->nama }}</h3>
                        <h5 class="widget-user-desc">{{ $instansi->alamat }}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src="{{ asset('template/dist/img/user3-128x128.jpg') }}" alt="Instansi">
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{ $totalSiswa }}</h5>
                                    <span class="description-text">TOTAL SISWA</span>
                                </div>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{ $totalJurnal }}</h5>
                                    <span class="description-text">TOTAL JURNAL</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">{{ number_format($averageNilai, 1) }}</h5>
                                    <span class="description-text">RATA-RATA NILAI</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-info-circle"></i> Detail Instansi</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <td><strong>Nama Instansi</strong></td>
                                <td>{{ $instansi->nama }}</td>
                            </tr>
                            <tr>
                                <td><strong>Alamat</strong></td>
                                <td>{{ $instansi->alamat }}</td>
                            </tr>
                            <tr>
                                <td><strong>Telepon</strong></td>
                                <td>{{ $instansi->telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>{{ $instansi->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pembimbing Lapangan</strong></td>
                                <td>{{ $instansi->pembimbing_lapangan ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Siswa di Instansi -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-users"></i> Siswa PKL di {{ $instansi->nama }} ({{ $totalSiswa }} Siswa)</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>NISN</th>
                                        <th>Guru Pembimbing</th>
                                        <th>Total Jurnal</th>
                                        <th>Jurnal Valid</th>
                                        <th>Rata-rata Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($siswaInstansi as $index => $siswa)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $siswa->name }}</td>
                                            <td>{{ $siswa->nisn }}</td>
                                            <td>{{ $siswa->guru->name ?? 'Belum ditentukan' }}</td>
                                            <td>{{ $siswa->jurnal_count }}</td>
                                            <td>{{ $siswa->jurnal_valid_count }}</td>
                                            <td>
                                                @if($siswa->avg_nilai)
                                                    <span class="label label-{{ $siswa->avg_nilai >= 80 ? 'success' : ($siswa->avg_nilai >= 70 ? 'warning' : 'danger') }}">
                                                        {{ number_format($siswa->avg_nilai, 1) }}
                                                    </span>
                                                @else
                                                    <span class="label label-default">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada siswa PKL di instansi ini</td>
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
            <div class="col-xs-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-book"></i> Jurnal Terbaru dari {{ $instansi->nama }} ({{ $totalJurnal }} Total)</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Siswa</th>
                                        <th>Kegiatan</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jurnalInstansi->take(15) as $index => $jurnal)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ is_object($jurnal->tanggal) ? $jurnal->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($jurnal->tanggal)) }}</td>
                                            <td>{{ $jurnal->siswa->name ?? 'N/A' }}</td>
                                            <td>{{ $jurnal->kegiatan }}</td>
                                            <td>{{ Str::limit($jurnal->deskripsi, 60) }}</td>
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
                                            <td colspan="6" class="text-center">Tidak ada jurnal dalam periode ini</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Penilaian Siswa -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-star"></i> Penilaian Siswa di {{ $instansi->nama }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Siswa</th>
                                        <th>Periode</th>
                                        <th>Guru Penilai</th>
                                        <th>Nilai</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($penilaianInstansi->take(10) as $index => $penilaian)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ is_object($penilaian->tanggal_penilaian) ? $penilaian->tanggal_penilaian->format('d/m/Y') : date('d/m/Y', strtotime($penilaian->tanggal_penilaian)) }}</td>
                                            <td>{{ $penilaian->siswa->name ?? 'N/A' }}</td>
                                            <td>{{ $penilaian->periode_penilaian }}</td>
                                            <td>{{ $penilaian->guru->name ?? 'N/A' }}</td>
                                            <td>
                                                <span class="label label-{{ $penilaian->nilai >= 80 ? 'success' : ($penilaian->nilai >= 70 ? 'warning' : 'danger') }}">
                                                    {{ $penilaian->nilai }}
                                                </span>
                                            </td>
                                            <td>{{ Str::limit($penilaian->catatan ?? '-', 50) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada penilaian dalam periode ini</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <!-- Tampilan ketika belum ada instansi yang dipilih -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-body text-center">
                        <i class="fa fa-info-circle fa-3x text-muted mb-3"></i>
                        <h4>Pilih Instansi untuk Melihat Laporan</h4>
                        <p class="text-muted">Silahkan pilih instansi dari dropdown filter di atas untuk melihat laporan detail aktivitas PKL di instansi tersebut.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</section>
<!-- /.content -->
@endsection
