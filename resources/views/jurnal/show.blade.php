<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\jurnal\show.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-eye"></i> Detail Jurnal PKL
        <small>Informasi lengkap jurnal kegiatan PKL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('jurnal.index') }}"><i class="fa fa-book"></i> Jurnal PKL</a></li>
        <li class="active"><i class="fa fa-eye"></i> Detail Jurnal</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-info-circle"></i> Detail Jurnal PKL</h3>
                    <div class="box-tools pull-right">
                        @if(auth()->user()->role == 'siswa' && auth()->user()->id == $jurnal->user_id)
                            <a href="{{ route('jurnal.edit', $jurnal->id) }}" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit"></i> Edit Jurnal
                            </a>
                        @endif
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <!-- Info Jurnal -->
                        <div class="col-md-6">
                            <h4><i class="fa fa-book"></i> Informasi Jurnal</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Nama Siswa</th>
                                    <td><strong>{{ $jurnal->user->name ?? 'N/A' }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kegiatan</th>
                                    <td>
                                        <span class="label label-info">
                                            {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Waktu Kegiatan</th>
                                    <td>
                                        <strong>{{ $jurnal->jam_mulai }}</strong> - <strong>{{ $jurnal->jam_selesai }}</strong>
                                        <br><small class="text-muted">
                                            Duration: 
                                            @php
                                                $start = \Carbon\Carbon::parse($jurnal->jam_mulai);
                                                $end = \Carbon\Carbon::parse($jurnal->jam_selesai);
                                                $duration = $start->diff($end);
                                                echo $duration->format('%h jam %i menit');
                                            @endphp
                                        </small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="label label-{{ $jurnal->status == 'menunggu_validasi' ? 'warning' : 'success' }}">
                                            {{ ucfirst(str_replace('_', ' ', $jurnal->status)) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Info Validasi -->
                        <div class="col-md-6">
                            <h4><i class="fa fa-check-circle"></i> Status Validasi</h4>
                            @if($jurnal->penilaian && $jurnal->penilaian->count() > 0)
                                @foreach($jurnal->penilaian as $penilaian)
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Status Validasi</th>
                                        <td>
                                            @if($penilaian->status_validasi == 'valid')
                                                <span class="label label-success">
                                                    <i class="fa fa-check"></i> Valid
                                                </span>
                                            @elseif($penilaian->status_validasi == 'tidak_valid')
                                                <span class="label label-danger">
                                                    <i class="fa fa-times"></i> Tidak Valid
                                                </span>
                                            @elseif($penilaian->status_validasi == 'revisi')
                                                <span class="label label-warning">
                                                    <i class="fa fa-edit"></i> Perlu Revisi
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Divalidasi Oleh</th>
                                        <td><strong>{{ $penilaian->guru->name ?? 'N/A' }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Validasi</th>
                                        <td>
                                            <span class="label label-primary">
                                                {{ $penilaian->created_at->format('d M Y H:i') }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                                @endforeach
                            @else
                                <div class="callout callout-warning">
                                    <h4><i class="fa fa-clock-o"></i> Menunggu Validasi</h4>
                                    Jurnal ini belum divalidasi oleh guru pembimbing.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Konten Jurnal -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h4><i class="fa fa-file-text-o"></i> Konten Jurnal</h4>
                            <div class="box box-solid">
                                <div class="box-header">
                                    <h3 class="box-title">Kegiatan</h3>
                                </div>
                                <div class="box-body">
                                    <p>{{ $jurnal->kegiatan }}</p>
                                </div>
                            </div>

                            @if($jurnal->deskripsi)
                            <div class="box box-solid">
                                <div class="box-header">
                                    <h3 class="box-title">Deskripsi Detail</h3>
                                </div>
                                <div class="box-body">
                                    <p>{{ $jurnal->deskripsi }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Catatan Validasi -->
                    @if($jurnal->penilaian && $jurnal->penilaian->count() > 0)
                        @foreach($jurnal->penilaian as $penilaian)
                            @if($penilaian->catatan_validasi)
                            <div class="row">
                                <div class="col-xs-12">
                                    <h4><i class="fa fa-comment"></i> Catatan Validasi</h4>
                                    <div class="callout callout-{{ $penilaian->status_validasi == 'valid' ? 'success' : ($penilaian->status_validasi == 'revisi' ? 'warning' : 'danger') }}">
                                        {{ $penilaian->catatan_validasi }}
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @endif
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('jurnal.index') }}" class="btn btn-default btn-block">
                                <i class="fa fa-arrow-left"></i> Kembali ke Daftar
                            </a>
                        </div>
                        <div class="col-md-6">
                            @if(auth()->user()->role == 'siswa' && auth()->user()->id == $jurnal->user_id)
                                <a href="{{ route('jurnal.edit', $jurnal->id) }}" class="btn btn-warning btn-block">
                                    <i class="fa fa-edit"></i> Edit Jurnal
                                </a>
                            @elseif(auth()->user()->role != 'siswa')
                                <a href="{{ route('penilaian.index') }}" class="btn btn-primary btn-block">
                                    <i class="fa fa-check-circle"></i> Lihat Validasi
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.callout {
    margin: 20px 0;
    padding: 20px;
    border-left: 5px solid #eee;
    border-radius: 3px;
}

.callout.callout-warning {
    border-left-color: #f39c12;
    background-color: #fcf8e3;
}

.callout.callout-success {
    border-left-color: #00a65a;
    background-color: #dff0d8;
}

.callout.callout-danger {
    border-left-color: #dd4b39;
    background-color: #f2dede;
}

.table td {
    vertical-align: middle;
}

.box.box-solid > .box-header {
    color: #fff;
    background: #3c8dbc;
    background-color: #3c8dbc;
}

.box.box-solid > .box-header a {
    color: #444;
}
</style>
@endpush