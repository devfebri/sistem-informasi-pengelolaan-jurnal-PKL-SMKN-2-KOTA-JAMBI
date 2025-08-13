@extends('layouts.master')
@section('title', 'Laporan Per Instansi')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-building-o"></i>
        Laporan Per Instansi
        <small>Detail Aktivitas PKL Berdasarkan Instansi</small>
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
                @if(isset($instansi) && $instansi)
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
                            @if(isset($instansiList))
                                @foreach($instansiList as $inst)
                                    <option value="{{ $inst->id }}" {{ request('instansi_id') == $inst->id ? 'selected' : '' }}>
                                        {{ $inst->nama }}
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

    @if(isset($instansi) && $instansi)
        <!-- Informasi Instansi -->
        <div class="row">
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-building-o"></i> Informasi Instansi</h3>
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
                                <td>{{ $instansi->telepon ?? 'Tidak tersedia' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>{{ $instansi->email ?? 'Tidak tersedia' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pembimbing Instansi</strong></td>
                                <td>{{ $instansi->pembimbing_instansi ?? 'Tidak tersedia' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box bg-green">
                            <span class="info-box-icon"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Siswa PKL</span>
                                <span class="info-box-number">{{ isset($totalSiswa) ? $totalSiswa : 0 }}</span>
                                <span class="info-box-more">Total siswa</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-blue">
                            <span class="info-box-icon"><i class="fa fa-book"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Jurnal</span>
                                <span class="info-box-number">{{ isset($totalJurnal) ? $totalJurnal : 0 }}</span>
                                <span class="info-box-more">Jurnal dibuat</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box bg-yellow">
                            <span class="info-box-icon"><i class="fa fa-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Jurnal Valid</span>
                                <span class="info-box-number">{{ isset($jurnalValid) ? $jurnalValid : 0 }}</span>
                                <span class="info-box-more">Jurnal tervalidasi</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-red">
                            <span class="info-box-icon"><i class="fa fa-star"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Rata-rata Nilai</span>
                                <span class="info-box-number">{{ isset($averageNilai) ? number_format($averageNilai, 1) : '0.0' }}</span>
                                <span class="info-box-more">Nilai rata-rata</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Siswa di Instansi -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-users"></i> Daftar Siswa PKL ({{ isset($totalSiswa) ? $totalSiswa : 0 }} Siswa)</h3>
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
                                        <th>Nilai Rata-rata</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($siswaInstansi))
                                        @forelse($siswaInstansi as $index => $siswa)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $siswa->name }}</td>
                                                <td>{{ $siswa->nisn }}</td>
                                                <td>{{ optional($siswa->guru)->name ?? 'Belum ditentukan' }}</td>
                                                <td>
                                                    <span class="badge bg-blue">{{ $siswa->jurnal_count ?? 0 }}</span>
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
                                                <td colspan="7" class="text-center">Tidak ada siswa PKL di instansi ini</td>
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

        <!-- Jurnal Terbaru -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-book"></i> Jurnal Terbaru (10 Terakhir)</h3>
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
                                    @if(isset($jurnalTerbaru))
                                        @forelse($jurnalTerbaru as $index => $jurnal)
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

        <!-- Penilaian Terbaru -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-star"></i> Penilaian Terbaru (10 Terakhir)</h3>
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
                                        <th>Guru Penilai</th>
                                        <th>Nilai</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($penilaianTerbaru))
                                        @forelse($penilaianTerbaru as $index => $penilaian)
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
        <!-- Tampilan ketika belum ada instansi yang dipilih -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-body text-center">
                        <i class="fa fa-info-circle fa-3x text-muted" style="margin-bottom: 15px;"></i>
                        <h4>Pilih Instansi untuk Melihat Laporan</h4>
                        <p class="text-muted">Silahkan pilih instansi dari dropdown filter di atas untuk melihat laporan detail siswa PKL dan aktivitas di instansi tersebut.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</section>
<!-- /.content -->
@endsection
