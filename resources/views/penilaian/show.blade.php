<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\penilaian\show.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-eye"></i> Detail Validasi Jurnal
        <small>Informasi validasi jurnal harian siswa PKL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('penilaian.index') }}"><i class="fa fa-check-circle"></i> Validasi Jurnal</a></li>
        <li class="active"><i class="fa fa-eye"></i> Detail Validasi</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-info-circle"></i> Detail Validasi Jurnal</h3>
                    <div class="box-tools pull-right">
                        @if(auth()->user()->role != 'siswa')
                            <a href="{{ route('penilaian.edit', $penilaian->id) }}" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit"></i> Edit Validasi
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
                                    <td><strong>{{ $penilaian->jurnal->user->name ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Jurnal</th>
                                    <td>
                                        <span class="label label-info">
                                            {{ \Carbon\Carbon::parse($penilaian->jurnal->tanggal)->format('d M Y') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Kegiatan</th>
                                    <td>{{ $penilaian->jurnal->kegiatan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ $penilaian->jurnal->deskripsi ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Info Validasi -->
                        <div class="col-md-6">
                            <h4><i class="fa fa-check-circle"></i> Informasi Validasi</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Status Validasi</th>
                                    <td>
                                        @if($penilaian->status_validasi)
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
                                        @else
                                            <span class="label label-default">
                                                <i class="fa fa-clock-o"></i> Menunggu Validasi
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Divalidasi Oleh</th>
                                    <td><strong>{{ $penilaian->guru->name ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Validasi</th>
                                    <td>
                                        @if($penilaian->created_at)
                                            <span class="label label-primary">
                                                {{ $penilaian->created_at->format('d M Y H:i') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Last Update</th>
                                    <td>
                                        @if($penilaian->updated_at)
                                            <small class="text-muted">
                                                {{ $penilaian->updated_at->format('d M Y H:i') }}
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

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
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('penilaian.index') }}" class="btn btn-default btn-block">
                                <i class="fa fa-arrow-left"></i> Kembali ke Daftar
                            </a>
                        </div>
                        <div class="col-md-6">
                            @if(auth()->user()->role != 'siswa')
                                <a href="{{ route('penilaian.edit', $penilaian->id) }}" class="btn btn-warning btn-block">
                                    <i class="fa fa-edit"></i> Edit Validasi
                                </a>
                            @else
                                <a href="{{ route('jurnal.show', $penilaian->jurnal->id) }}" class="btn btn-info btn-block">
                                    <i class="fa fa-eye"></i> Lihat Detail Jurnal
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

.callout.callout-success {
    border-left-color: #00a65a;
    background-color: #dff0d8;
}

.callout.callout-warning {
    border-left-color: #f39c12;
    background-color: #fcf8e3;
}

.callout.callout-danger {
    border-left-color: #dd4b39;
    background-color: #f2dede;
}

.table td {
    vertical-align: middle;
}
</style>
@endpush