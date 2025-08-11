@extends('layouts.master')
@section('title', 'Dashboard Pimpinan')
@section('content')
<div class="content-header">
    <h1 class="mb-4">Laporan PKL - Pimpinan</h1>
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
