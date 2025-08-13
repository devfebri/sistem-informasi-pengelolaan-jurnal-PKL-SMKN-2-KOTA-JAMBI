@extends('layouts.master')
@section('title', 'Laporan Per Siswa')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa fa-graduation-cap"></i>
        Laporan Per Siswa
        <small>Detail Aktivitas Jurnal PKL Siswa</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('laporan.index') }}">Laporan</a></li>
        <li class="active">Laporan Per Siswa</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Filter Box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-filter"></i> Filter Laporan Siswa</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('laporan.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
                @if(isset($siswa) && $siswa)
                    <a href="{{ route('laporan.siswa', array_merge(request()->all(), ['download' => 'pdf'])) }}" 
                       class="btn btn-danger btn-sm">
                        <i class="fa fa-file-pdf-o"></i> Download PDF
                    </a>
                @endif
            </div>
        </div>
        <div class="box-body">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('laporan.siswa') }}" class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="siswa_id">Pilih Siswa:</label>
                        <select name="siswa_id" id="siswa_id" class="form-control" required>
                            <option value="">-- Pilih Siswa --</option>
                            @if(isset($siswaList))
                                @foreach($siswaList as $s)
                                    <option value="{{ $s->id }}" {{ request('siswa_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->name }} - {{ $s->nisn }}
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

    @if(isset($siswa) && $siswa)
        <!-- Informasi Siswa -->
        <div class="row">
            <div class="col-md-6">
                <div class="box box-widget widget-user">
                    <div class="widget-user-header bg-green">
                        <h3 class="widget-user-username">{{ $siswa->name }}</h3>
                        <h5 class="widget-user-desc">NISN: {{ $siswa->nisn }}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src="{{ asset('template/dist/img/user2-160x160.jpg') }}" alt="User Avatar">
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{ isset($totalJurnal) ? $totalJurnal : 0 }}</h5>
                                    <span class="description-text">TOTAL JURNAL</span>
                                </div>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{ isset($jurnalValid) ? $jurnalValid : 0 }}</h5>
                                    <span class="description-text">JURNAL VALID</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">{{ isset($averageNilai) ? number_format($averageNilai, 1) : '0.0' }}</h5>
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
                        <h3 class="box-title"><i class="fa fa-info-circle"></i> Detail Siswa</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <td><strong>Nama Lengkap</strong></td>
                                <td>{{ $siswa->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>NISN</strong></td>
                                <td>{{ $siswa->nisn }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>{{ $siswa->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Guru Pembimbing</strong></td>
                                <td>{{ optional($siswa->guru)->name ?? 'Belum ditentukan' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Instansi PKL</strong></td>
                                <td>{{ optional($siswa->instansi)->nama ?? 'Belum ditentukan' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jurnal Siswa -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-book"></i> Jurnal Harian ({{ isset($totalJurnal) ? $totalJurnal : 0 }} Total)</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Kegiatan</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($jurnalSiswa))
                                        @forelse($jurnalSiswa as $index => $jurnal)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ is_object($jurnal->tanggal) ? $jurnal->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($jurnal->tanggal)) }}</td>
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
                                                <td colspan="5" class="text-center">Tidak ada jurnal dalam periode ini</td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada data jurnal</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Penilaian Berkala -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-star"></i> Penilaian Berkala ({{ isset($totalPenilaian) ? $totalPenilaian : 0 }} Total)</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Penilaian</th>
                                        <th>Periode</th>
                                        <th>Guru Penilai</th>
                                        <th>Nilai</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($penilaianSiswa))
                                        @forelse($penilaianSiswa as $index => $penilaian)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ is_object($penilaian->tanggal_penilaian) ? $penilaian->tanggal_penilaian->format('d/m/Y') : date('d/m/Y', strtotime($penilaian->tanggal_penilaian)) }}</td>
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
                                                <td colspan="6" class="text-center">Tidak ada penilaian dalam periode ini</td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data penilaian</td>
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
        <!-- Tampilan ketika belum ada siswa yang dipilih -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-body text-center">
                        <i class="fa fa-info-circle fa-3x text-muted" style="margin-bottom: 15px;"></i>
                        <h4>Pilih Siswa untuk Melihat Laporan</h4>
                        <p class="text-muted">Silahkan pilih siswa dari dropdown filter di atas untuk melihat laporan detail jurnal dan penilaian siswa tersebut.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</section>
<!-- /.content -->
@endsection
