@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-eye"></i> Detail Penilaian Berkala
        <small>Informasi lengkap penilaian nilai berkala siswa</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('penilaian-berkala.index') }}"><i class="fa fa-star"></i> Penilaian Berkala</a></li>
        <li class="active"><i class="fa fa-eye"></i> Detail</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-eye"></i> Detail Penilaian Berkala</h3>
                    <div class="box-tools pull-right">
                        @if(Auth::user()->role == 'guru')
                            <a href="{{ route('penilaian-berkala.edit', $penilaian->id) }}" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                        @endif
                        <a href="{{ route('penilaian-berkala.index') }}" class="btn btn-default btn-sm">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
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

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th width="200">Nama Guru Penilai</th>
                                        <td>
                                            <strong>{{ $penilaian->guru->name ?? 'N/A' }}</strong>
                                            @if($penilaian->guru->nip)
                                                <br><small class="text-muted">NIP: {{ $penilaian->guru->nip }}</small>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nama Siswa</th>                                        <td>
                                            <strong>{{ $penilaian->siswa->name ?? 'N/A' }}</strong>
                                            @if($penilaian->siswa->nisn)
                                                <br><small class="text-muted">NISN: {{ $penilaian->siswa->nisn }}</small>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Periode Penilaian</th>
                                        <td>
                                            <span class="label label-{{ $penilaian->periode_penilaian == 'triwulan' ? 'info' : 'warning' }} label-lg">
                                                {{ ucfirst($penilaian->periode_penilaian) }}
                                            </span>
                                            <small class="text-muted">
                                                ({{ $penilaian->periode_penilaian == 'triwulan' ? '3 Bulan' : '6 Bulan' }})
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Penilaian</th>
                                        <td>
                                            <span class="label label-primary label-lg">
                                                {{ \Carbon\Carbon::parse($penilaian->tanggal_penilaian)->format('d F Y') }}
                                            </span>
                                            <small class="text-muted">
                                                ({{ \Carbon\Carbon::parse($penilaian->tanggal_penilaian)->diffForHumans() }})
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nilai</th>
                                        <td>
                                            <span class="badge bg-{{ $penilaian->nilai >= 80 ? 'green' : ($penilaian->nilai >= 70 ? 'yellow' : 'red') }}" style="font-size: 18px; padding: 8px 12px;">
                                                {{ $penilaian->nilai }}
                                            </span>
                                            <br>
                                            <small class="text-muted">
                                                Grade: 
                                                @if($penilaian->nilai >= 90)
                                                    <strong class="text-green">A (Sangat Baik)</strong>
                                                @elseif($penilaian->nilai >= 80)
                                                    <strong class="text-blue">B (Baik)</strong>
                                                @elseif($penilaian->nilai >= 70)
                                                    <strong class="text-yellow">C (Cukup)</strong>
                                                @elseif($penilaian->nilai >= 60)
                                                    <strong class="text-orange">D (Kurang)</strong>
                                                @else
                                                    <strong class="text-red">E (Sangat Kurang)</strong>
                                                @endif
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Catatan Nilai</th>
                                        <td>
                                            @if($penilaian->catatan_nilai)
                                                <div class="well well-sm">
                                                    {{ $penilaian->catatan_nilai }}
                                                </div>
                                            @else
                                                <span class="text-muted">Tidak ada catatan</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Dibuat Pada</th>
                                        <td>
                                            <span class="text-muted">
                                                {{ $penilaian->created_at->format('d F Y H:i') }}
                                                ({{ $penilaian->created_at->diffForHumans() }})
                                            </span>
                                        </td>
                                    </tr>
                                    @if($penilaian->updated_at != $penilaian->created_at)
                                    <tr>
                                        <th>Terakhir Diupdate</th>
                                        <td>
                                            <span class="text-muted">
                                                {{ $penilaian->updated_at->format('d F Y H:i') }}
                                                ({{ $penilaian->updated_at->diffForHumans() }})
                                            </span>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            @if(Auth::user()->role == 'guru')
                                <a href="{{ route('penilaian-berkala.edit', $penilaian->id) }}" class="btn btn-warning">
                                    <i class="fa fa-edit"></i> Edit Penilaian
                                </a>
                                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                                    <i class="fa fa-trash"></i> Hapus Penilaian
                                </button>
                            @endif
                            <a href="{{ route('penilaian-berkala.index') }}" class="btn btn-default">
                                <i class="fa fa-arrow-left"></i> Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if(Auth::user()->role == 'guru')
<!-- Hidden delete form -->
<form id="delete-form" action="{{ route('penilaian-berkala.destroy', $penilaian->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endif
@endsection

@push('scripts')
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Hapus Penilaian?',
            text: "Data penilaian berkala ini akan dihapus permanen!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                document.getElementById('delete-form').submit();
            }
        });
    }
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
<style>
.label-lg {
    font-size: 14px;
    padding: 6px 10px;
}

.well {
    min-height: 20px;
    padding: 19px;
    margin-bottom: 20px;
    background-color: #f5f5f5;
    border: 1px solid #e3e3e3;
    border-radius: 4px;
    box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
}

.well-sm {
    padding: 9px;
    border-radius: 3px;
}

.text-orange {
    color: #ff851b !important;
}
</style>
@endpush
