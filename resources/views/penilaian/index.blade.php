<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\penilaian\index.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-check-circle"></i> 
        @if(auth()->user()->role == 'siswa')
            Status Validasi Jurnal PKL
        @else
            Validasi Jurnal Harian Siswa
        @endif
        <small>
            @if(auth()->user()->role == 'siswa')
                Lihat status validasi jurnal PKL Anda
            @else
                Validasi dan berikan feedback untuk jurnal harian siswa
            @endif
        </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-check-circle"></i> Validasi Jurnal</li>
    </ol>
</section>

<section class="content">
    @if(auth()->user()->role != 'siswa')
    <!-- Statistik untuk Guru/Admin -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $penilaians->count() }}</h3>
                    <p>Total Jurnal</p>
                </div>
                <div class="icon">
                    <i class="fa fa-book"></i>
                </div>
            </div>
        </div>        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $penilaians->whereNotNull('status_validasi')->count() }}</h3>
                    <p>Sudah Divalidasi</p>
                </div>
                <div class="icon">
                    <i class="fa fa-check"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $penilaians->whereNull('status_validasi')->count() }}</h3>
                    <p>Menunggu Validasi</p>
                </div>
                <div class="icon">
                    <i class="fa fa-clock-o"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $penilaians->where('status_validasi', 'valid')->count() }}</h3>
                    <p>Jurnal Valid</p>
                </div>
                <div class="icon">
                    <i class="fa fa-star"></i>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-list"></i> 
                        @if(auth()->user()->role == 'siswa')
                            Daftar Jurnal PKL Anda
                        @else
                            Daftar Jurnal Siswa
                        @endif
                    </h3>
                    <div class="box-tools pull-right">
                        @if(auth()->user()->role != 'siswa')
                            <a href="{{ route('penilaian.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Validasi Jurnal
                            </a>
                        @endif
                    </div>
                </div>
                <div class="box-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table id="penilaian-table" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    @if(auth()->user()->role != 'siswa')
                                        <th>Nama Siswa</th>
                                    @endif                                    <th>Tanggal</th>
                                    <th>Kegiatan</th>
                                    <th>Status Validasi</th>
                                    <th>Catatan Validasi</th>
                                    @if(auth()->user()->role == 'siswa')
                                        <th>Divalidasi Oleh</th>
                                    @endif
                                    @if(auth()->user()->role != 'siswa')
                                        <th width="120">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($penilaians as $key => $penilaian)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    @if(auth()->user()->role != 'siswa')
                                        <td>
                                            <strong>{{ $penilaian->nama_siswa ?? 'N/A' }}</strong>
                                        </td>
                                    @endif
                                    <td>
                                        <span class="label label-info">
                                            {{ \Carbon\Carbon::parse($penilaian->tanggal)->format('d M Y') }}
                                        </span>
                                    </td>                                    <td>
                                        <small>{{ Str::limit($penilaian->kegiatan, 50) }}</small>
                                    </td>
                                    <td class="text-center">
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
                                            @if($penilaian->tanggal_validasi)
                                                <br><small class="text-muted">{{ \Carbon\Carbon::parse($penilaian->tanggal_validasi)->format('d M Y H:i') }}</small>
                                            @endif
                                        @else
                                            <span class="label label-default">
                                                <i class="fa fa-clock-o"></i> Menunggu Validasi
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($penilaian->catatan_validasi)
                                            <small>{{ Str::limit($penilaian->catatan_validasi, 50) }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    @if(auth()->user()->role == 'siswa')
                                        <td>
                                            @if($penilaian->nama_guru)
                                                <small class="text-success">{{ $penilaian->nama_guru }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    @endif
                                    @if(auth()->user()->role != 'siswa')                                        <td>
                                            <div class="btn-group">
                                                @if($penilaian->status_validasi)
                                                    <a href="{{ route('penilaian.edit', $penilaian->id) }}" 
                                                       class="btn btn-warning btn-xs" title="Edit Validasi">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ route('jurnal.show', $penilaian->id) }}" 
                                                   class="btn btn-info btn-xs" title="Lihat Detail">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#penilaian-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            },
            "responsive": true,
            "autoWidth": false,
            "order": [[ @if(auth()->user()->role != 'siswa') 2 @else 1 @endif, "desc" ]], // Sort by tanggal descending
            "columnDefs": [
                { "orderable": false, "targets": [-1] } // Disable sorting for last column (aksi)
            ]
        });
    });
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap.min.css">
<style>
.small-box h3 {
    font-size: 2.2rem;
    font-weight: bold;
}
.table td {
    vertical-align: middle;
}
.btn-group .btn {
    margin-right: 2px;
}
</style>
@endpush