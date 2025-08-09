@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-star"></i>        @if(Auth::user()->role == 'guru')
            Penilaian Berkala Siswa
        @elseif(Auth::user()->role == 'siswa')
            Nilai Penilaian Saya
        @else
            Data Penilaian Berkala
        @endif
        <small>            @if(Auth::user()->role == 'guru')
                Kelola penilaian nilai berkala siswa bimbingan (per 3-6 bulan)
            @elseif(Auth::user()->role == 'siswa')
                Lihat semua nilai penilaian berkala dari guru pembimbing
            @else
                Monitor semua penilaian nilai berkala siswa
            @endif
        </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-star"></i> Penilaian Berkala</li>
    </ol>
</section>

<section class="content">    @if(Auth::user()->role == 'guru')
    <!-- Statistik untuk Guru -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $penilaians->count() }}</h3>
                    <p>Total Penilaian</p>
                </div>
                <div class="icon">
                    <i class="fa fa-star"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $penilaians->where('periode_penilaian', 'triwulan')->count() }}</h3>
                    <p>Penilaian Triwulan</p>
                </div>
                <div class="icon">
                    <i class="fa fa-calendar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $penilaians->where('periode_penilaian', 'semester')->count() }}</h3>
                    <p>Penilaian Semester</p>
                </div>
                <div class="icon">
                    <i class="fa fa-calendar-o"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $penilaians->avg('nilai') ? number_format($penilaians->avg('nilai'), 1) : '0' }}</h3>
                    <p>Rata-rata Nilai</p>
                </div>
                <div class="icon">
                    <i class="fa fa-line-chart"></i>
                </div>
            </div>
        </div>
    </div>
    @elseif(Auth::user()->role == 'siswa')
    <!-- Statistik untuk Siswa -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>{{ $penilaians->count() }}</h3>
                    <p>Total Penilaian</p>
                </div>
                <div class="icon">
                    <i class="fa fa-star"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $penilaians->avg('nilai') ? number_format($penilaians->avg('nilai'), 1) : '0' }}</h3>
                    <p>Nilai Rata-rata</p>
                </div>
                <div class="icon">
                    <i class="fa fa-line-chart"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $penilaians->max('nilai') ?? '0' }}</h3>
                    <p>Nilai Tertinggi</p>
                </div>
                <div class="icon">
                    <i class="fa fa-trophy"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $penilaians->where('nilai', '>=', 80)->count() }}</h3>
                    <p>Nilai ≥ 80</p>
                </div>
                <div class="icon">
                    <i class="fa fa-check-circle"></i>
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
                        <i class="fa fa-list"></i>                        @if(Auth::user()->role == 'guru')
                            Daftar Penilaian Berkala Siswa Bimbingan
                        @elseif(Auth::user()->role == 'siswa')
                            Daftar Nilai Penilaian Berkala Saya
                        @else
                            Daftar Semua Penilaian Berkala
                        @endif
                    </h3>
                    <div class="box-tools pull-right">                        @if(Auth::user()->role == 'guru')
                            <a href="{{ route('penilaian-berkala.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Tambah Penilaian
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
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-ban"></i> Error!</h4>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($penilaians->count() > 0)
                        <div class="table-responsive">
                            <table id="penilaian-berkala-table" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>                                        @if(Auth::user()->role != 'guru' && Auth::user()->role != 'siswa')
                                            <th>Nama Guru</th>
                                        @endif
                                        @if(Auth::user()->role != 'siswa')
                                            <th>Nama Siswa</th>
                                        @endif
                                        @if(Auth::user()->role == 'siswa')
                                            <th>Nama Guru Penilai</th>
                                        @endif
                                        <th>Periode</th>
                                        <th>Tanggal Penilaian</th>
                                        <th>Nilai</th>
                                        <th>Catatan</th>
                                        <th width="120">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($penilaians as $key => $penilaian)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>                                        @if(Auth::user()->role != 'guru' && Auth::user()->role != 'siswa')
                                            <td>
                                                <strong>{{ $penilaian->guru->name ?? 'N/A' }}</strong>
                                            </td>
                                        @endif                                        
                                        @if(Auth::user()->role != 'siswa')
                                            <td>
                                                <strong>{{ $penilaian->siswa->name ?? 'N/A' }}</strong>
                                            </td>
                                        @endif
                                        @if(Auth::user()->role == 'siswa')
                                            <td>
                                                <strong>{{ $penilaian->guru->name ?? 'N/A' }}</strong>
                                            </td>
                                        @endif
                                        <td>
                                            <span class="label label-{{ $penilaian->periode_penilaian == 'triwulan' ? 'info' : 'warning' }}">
                                                {{ ucfirst($penilaian->periode_penilaian) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="label label-primary">
                                                {{ \Carbon\Carbon::parse($penilaian->tanggal_penilaian)->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $penilaian->nilai >= 80 ? 'green' : ($penilaian->nilai >= 70 ? 'yellow' : 'red') }}">
                                                {{ $penilaian->nilai }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($penilaian->catatan_nilai)
                                                <small>{{ Str::limit($penilaian->catatan_nilai, 50) }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('penilaian-berkala.show', $penilaian->id) }}" class="btn btn-info btn-xs" title="Detail">
                                                    <i class="fa fa-eye"></i>
                                                </a>                                                @if(Auth::user()->role == 'guru' || Auth::user()->role == 'admin')
                                                    <a href="{{ route('penilaian-berkala.edit', $penilaian->id) }}" class="btn btn-warning btn-xs" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if(Auth::user()->role == 'guru' || Auth::user()->role == 'admin')
                                                    <form action="{{ route('penilaian-berkala.destroy', $penilaian->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-xs" title="Hapus" 
                                                                onclick="return confirm('Yakin hapus penilaian ini?')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="callout callout-info">
                            <h4><i class="fa fa-info"></i> Informasi</h4>                            @if(Auth::user()->role == 'guru')
                                Belum ada penilaian berkala yang dibuat. Klik "Tambah Penilaian" untuk mulai memberikan penilaian berkala pada siswa bimbingan Anda.
                            @elseif(Auth::user()->role == 'siswa')
                                Belum ada penilaian berkala dari guru pembimbing Anda. Guru akan memberikan penilaian berkala secara triwulan atau semester.
                            @else
                                Belum ada data penilaian berkala dari guru-guru.
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#penilaian-berkala-table').DataTable({
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "order": [[ 4, "desc" ]] // Sort by tanggal penilaian descending
        });
    });
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.min.css') }}">
<style>
.small-box .icon {
    font-size: 60px;
}

.callout {
    margin: 20px 0;
    padding: 20px;
    border-left: 5px solid #eee;
    border-radius: 3px;
}

.callout.callout-info {
    border-left-color: #3c8dbc;
    background-color: #d9edf7;
}
</style>
@endpush
