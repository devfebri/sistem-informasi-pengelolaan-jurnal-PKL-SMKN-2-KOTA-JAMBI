@extends('layouts.master')
@section('title', 'Laporan Per Guru')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-user-md"></i>
        Laporan Per Guru
        <small>Detail Bimbingan dan Supervisi Guru PKL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('laporan.index') }}">Laporan</a></li>
        <li class="active">Laporan Per Guru</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Filter Box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-filter"></i> Filter Laporan Guru</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('laporan.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
                @if(isset($guru) && $guru)
                    <a href="{{ route('laporan.guru', array_merge(request()->all(), ['download' => 'pdf'])) }}" 
                       class="btn btn-danger btn-sm">
                        <i class="fa fa-file-pdf-o"></i> Download PDF
                    </a>
                @endif
            </div>
        </div>
        <div class="box-body">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('laporan.guru') }}" class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="guru_id">Pilih Guru:</label>
                        <select name="guru_id" id="guru_id" class="form-control" required>
                            <option value="">-- Pilih Guru --</option>
                            @if(isset($guruList))
                                @foreach($guruList as $g)
                                    <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>
                                        {{ $g->name }} - {{ $g->nip ?? 'No NIP' }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Mulai:</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" 
                               class="form-control" value="{{ isset($tanggalMulai) ? $tanggalMulai : '' }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tanggal_selesai">Tanggal Selesai:</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" 
                               class="form-control" value="{{ isset($tanggalSelesai) ? $tanggalSelesai : '' }}">
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

    @if(isset($guru) && $guru)
        <!-- Informasi Guru -->
        <div class="row">
            <div class="col-md-6">
                <div class="box box-widget widget-user">
                    <div class="widget-user-header" style="background: linear-gradient(45deg, #605ca8, #9b59b6);">
                        <h3 class="widget-user-username">{{ $guru->name }}</h3>
                        <h5 class="widget-user-desc">NIP: {{ $guru->nip ?? 'Belum ada NIP' }}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src="{{ asset('template/dist/img/user1-128x128.jpg') }}" alt="User Avatar">
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{ isset($totalSiswaBimbingan) ? $totalSiswaBimbingan : 0 }}</h5>
                                    <span class="description-text">SISWA BIMBINGAN</span>
                                </div>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{ isset($totalJurnalBimbingan) ? $totalJurnalBimbingan : 0 }}</h5>
                                    <span class="description-text">TOTAL JURNAL</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">{{ isset($averageNilaiBimbingan) ? number_format($averageNilaiBimbingan, 1) : '0.0' }}</h5>
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
                        <h3 class="box-title"><i class="fa fa-info-circle"></i> Detail Guru</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <td><strong>Nama Lengkap</strong></td>
                                <td>{{ $guru->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>NIP</strong></td>
                                <td>{{ $guru->nip ?? 'Belum ada NIP' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>{{ $guru->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>No. Telepon</strong></td>
                                <td>{{ $guru->phone ?? 'Belum ada nomor' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Kelamin</strong></td>
                                <td>{{ $guru->gender ? ucfirst($guru->gender) : 'Belum diset' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Bimbingan -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-purple">
                    <span class="info-box-icon"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Siswa Bimbingan</span>
                        <span class="info-box-number">{{ isset($totalSiswaBimbingan) ? $totalSiswaBimbingan : 0 }}</span>
                        <span class="info-box-more">Total siswa</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-blue">
                    <span class="info-box-icon"><i class="fa fa-book"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Jurnal</span>
                        <span class="info-box-number">{{ isset($totalJurnalBimbingan) ? $totalJurnalBimbingan : 0 }}</span>
                        <span class="info-box-more">Jurnal dibuat</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Jurnal Valid</span>
                        <span class="info-box-number">{{ isset($jurnalValidBimbingan) ? $jurnalValidBimbingan : 0 }}</span>
                        <span class="info-box-more">Jurnal tervalidasi</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-star"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Rata-rata Nilai</span>
                        <span class="info-box-number">{{ isset($averageNilaiBimbingan) ? number_format($averageNilaiBimbingan, 1) : '0.0' }}</span>
                        <span class="info-box-more">Nilai rata-rata</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Siswa Bimbingan -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-users"></i> Daftar Siswa Bimbingan ({{ isset($totalSiswaBimbingan) ? $totalSiswaBimbingan : 0 }} Siswa)</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>NISN</th>
                                        <th>Instansi PKL</th>
                                        <th>Total Jurnals</th>
                                        <th>Jurnal Valid</th>
                                        <th>Nilai Rata-rata</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($siswaBimbingan))
                                        @forelse($siswaBimbingan as $index => $siswa)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $siswa->name }}</td>
                                                <td>{{ $siswa->nisn }}</td>
                                                <td>{{ optional($siswa->instansi)->nama ?? 'Belum ditentukan' }}</td>
                                                <td>
                                                    <span class="badge bg-blue">{{ $siswa->jurnalcount($siswa->id) ?? 0 }}</span>

                                                </td>
                                                <td> 
                                                    <span class="badge bg-green">{{ $siswa->jurnal_valid_count ?? 0 }}</span>
                                                </td>
                                                <td>
                                                    <span class="label label-{{ $siswa->avg_nilai >= 80 ? 'success' : ($siswa->avg_nilai >= 70 ? 'warning' : 'danger') }}">
                                                        {{ $siswa->avg_nilai ? number_format($siswa->avg_nilai, 1) : '0.0' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada siswa bimbingan</td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data siswa</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jurnal Terbaru dari Siswa Bimbingan -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-book"></i> Jurnal Terbaru Siswa Bimbingan (20 Terakhir)</h3>
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
                                    @if(isset($jurnalSiswaBimbingan))
                                        @forelse($jurnalSiswaBimbingan as $index => $jurnal)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ is_object($jurnal->tanggal) ? $jurnal->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($jurnal->tanggal)) }}</td>
                                                <td>{{ optional($jurnal->siswa)->name ?? 'N/A' }}</td>
                                                <td>{{ $jurnal->kegiatan }}</td>
                                                <td>{{ Str::limit($jurnal->deskripsi, 80) }}</td>
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
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data jurnal</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Penilaian Terbaru dari Siswa Bimbingan -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-star"></i> Penilaian Terbaru Siswa Bimbingan (20 Terakhir)</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Penilaian</th>
                                        <th>Siswa</th>
                                        <th>Periode</th>
                                        <th>Penilai</th>
                                        <th>Nilai</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($penilaianSiswaBimbingan))
                                        @forelse($penilaianSiswaBimbingan as $index => $penilaian)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ is_object($penilaian->tanggal_penilaian) ? $penilaian->tanggal_penilaian->format('d/m/Y') : date('d/m/Y', strtotime($penilaian->tanggal_penilaian)) }}</td>
                                                <td>{{ optional($penilaian->siswa)->name ?? 'N/A' }}</td>
                                                <td>{{ $penilaian->periode_penilaian }}</td>
                                                <td>{{ optional($penilaian->guru)->name ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="label label-{{ $penilaian->nilai >= 80 ? 'success' : ($penilaian->nilai >= 70 ? 'warning' : 'danger') }}">
                                                        {{ $penilaian->nilai }}
                                                    </span>
                                                </td>
                                                <td>{{ $penilaian->catatan ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada penilaian dalam periode ini</td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data penilaian</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <!-- Tampilan ketika belum ada guru yang dipilih -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-body text-center">
                        <i class="fa fa-info-circle fa-3x text-muted" style="margin-bottom: 15px;"></i>
                        <h4>Pilih Guru untuk Melihat Laporan</h4>
                        <p class="text-muted">Silahkan pilih guru dari dropdown filter di atas untuk melihat laporan detail siswa bimbingan dan aktivitas supervisi guru tersebut.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</section>
<!-- /.content -->
@endsection
