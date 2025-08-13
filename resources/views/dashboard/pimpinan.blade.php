@extends('layouts.master')
@section('title', 'Dashboard Pimpinan')
@section('content')
<div class="content-header">
    <h1 class="mb-4">Dashboard Pimpinan</h1>
</div>

<!-- Quick Access Laporan -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-body text-center">
                <i class="fa fa-chart-bar fa-3x text-primary mb-3"></i>
                <h4>Laporan Lengkap</h4>
                <a href="{{ route('laporan.lengkap') }}" class="btn btn-primary btn-block">
                    <i class="fa fa-eye mr-1"></i>Lihat Laporan
                </a>
                <a href="{{ route('laporan.lengkap', ['download' => 'pdf']) }}" class="btn btn-danger btn-block mt-2">
                    <i class="fa fa-file-pdf-o mr-1"></i>Download PDF
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box box-success">
            <div class="box-body text-center">
                <i class="fa fa-graduation-cap fa-3x text-success mb-3"></i>
                <h4>Laporan Per Siswa</h4>
                <a href="{{ route('laporan.siswa') }}" class="btn btn-success btn-block">
                    <i class="fa fa-eye mr-1"></i>Lihat Laporan
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box box-info">
            <div class="box-body text-center">
                <i class="fa fa-building fa-3x text-info mb-3"></i>
                <h4>Laporan Per Instansi</h4>
                <a href="{{ route('laporan.instansi') }}" class="btn btn-info btn-block">
                    <i class="fa fa-eye mr-1"></i>Lihat Laporan
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box box-warning">
            <div class="box-body text-center">
                <i class="fa fa-file-text fa-3x text-warning mb-3"></i>
                <h4>Pusat Laporan</h4>
                <a href="{{ route('laporan.index') }}" class="btn btn-warning btn-block">
                    <i class="fa fa-home mr-1"></i>Pusat Laporan
                </a>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Rekapitulasi Jurnal & Penilaian</h3>
    </div>
    <div class="box-body">
        <p>Berikut adalah laporan rekapitulasi seluruh jurnal harian dan penilaian berkala siswa PKL.</p>
        <ul>
            <li>Total Jurnal Harian: <strong>{{ $totalJurnal }}</strong></li>
            <li>Total Penilaian Berkala: <strong>{{ $totalPenilaian }}</strong></li>
            <li>Total Siswa PKL: <strong>{{ $totalSiswa }}</strong></li>
            <li>Total Guru Pembimbing: <strong>{{ $totalGuru }}</strong></li>
        </ul>
        <hr>
        <h4>Daftar Jurnal Terbaru</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Siswa</th>
                    <th>Instansi</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jurnals as $jurnal)
                <tr>
                    <td>{{ $jurnal->tanggal }}</td>
                    <td>{{ $jurnal->siswa->name ?? '-' }}</td>
                    <td>{{ $jurnal->siswa->instansi->nama ?? '-' }}</td>
                    <td>{{ Str::limit($jurnal->deskripsi, 50) }}</td>
                    <td>
                        @if($jurnal->status == 'pending')
                            <span class="label label-warning">Menunggu</span>
                        @elseif($jurnal->status == 'approved')
                            <span class="label label-success">Disetujui</span>
                        @elseif($jurnal->status == 'rejected')
                            <span class="label label-danger">Ditolak</span>
                        @else
                            {{ ucfirst($jurnal->status) }}
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">Tidak ada data jurnal.</td></tr>
                @endforelse
            </tbody>
        </table>
        <hr>
        <h4>Daftar Penilaian Berkala Terbaru</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Siswa</th>
                    <th>Guru Pembimbing</th>
                    <th>Nilai</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penilaians as $penilaian)
                <tr>
                    <td>{{ $penilaian->tanggal_penilaian ?? $penilaian->created_at->format('Y-m-d') }}</td>
                    <td>{{ $penilaian->siswa->name ?? '-' }}</td>
                    <td>{{ $penilaian->guru->name ?? '-' }}</td>
                    <td>{{ $penilaian->nilai ?? '-' }}</td>
                    <td>{{ $penilaian->catatan_nilai ?? $penilaian->periode_penilaian ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">Tidak ada data penilaian.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
