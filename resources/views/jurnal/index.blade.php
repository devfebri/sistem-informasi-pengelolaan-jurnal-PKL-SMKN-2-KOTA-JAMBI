<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\jurnal\index.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-book"></i>        @if(Auth::user()->role == 'siswa')
            Laporan Kegiatan Siswa
        @elseif(Auth::user()->role == 'guru')
            Laporan Kegiatan Siswa Bimbingan
        @else
            Data Laporan Kegiatan Siswa
        @endif
        <small>
            @if(Auth::user()->role == 'siswa')
                Kelola jurnal kegiatan PKL Anda
            @elseif(Auth::user()->role == 'guru')
                Monitor jurnal siswa bimbingan Anda
            @else
                Monitor semua jurnal PKL siswa
            @endif
        </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-book"></i> Jurnal PKL</li>
    </ol>
</section>

<section class="content">
    @if(Auth::user()->role == 'siswa')
    <!-- Statistik untuk Siswa -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $jurnals->count() }}</h3>
                    <p>Total Jurnal</p>
                </div>
                <div class="icon">
                    <i class="fa fa-book"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $jurnals->where('status_validasi', 'valid')->count() }}</h3>
                    <p>Jurnal Valid</p>
                </div>
                <div class="icon">
                    <i class="fa fa-check"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $jurnals->where('status_validasi', 'revisi')->count() }}</h3>
                    <p>Perlu Revisi</p>
                </div>
                <div class="icon">
                    <i class="fa fa-edit"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $jurnals->whereNull('status_validasi')->count() }}</h3>
                    <p>Menunggu Validasi</p>
                </div>
                <div class="icon">
                    <i class="fa fa-clock-o"></i>
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
                        <i class="fa fa-list"></i>                        @if(Auth::user()->role == 'siswa')
                            Daftar Jurnal PKL Anda
                        @elseif(Auth::user()->role == 'guru')
                            Daftar Jurnal Siswa Bimbingan
                        @else
                            Daftar Semua Jurnal PKL
                        @endif
                    </h3>
                    <div class="box-tools pull-right">                        @if(Auth::user()->role == 'siswa')
                            <a href="{{ route('jurnal.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Tambah Jurnal
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
                    
                    <div class="table-responsive">
                        <table id="jurnal-table" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th width="50">No</th>                                    @if(Auth::user()->role != 'siswa')
                                        <th>Nama Siswa</th>
                                    @endif                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Kegiatan</th>
                                    <th>Status Validasi</th>
                                    @if(Auth::user()->role == 'guru')
                                        <th>Validasi</th>
                                    @endif
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jurnals as $key => $jurnal)
                                <tr>
                                    <td>{{ $key + 1 }}</td>                                    @if(Auth::user()->role != 'siswa')
                                        <td>
                                            <strong>{{ $jurnal->nama_siswa ?? 'N/A' }}</strong>
                                        </td>
                                    @endif
                                    <td>
                                        <span class="label label-info">
                                            {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $jurnal->jam_mulai }} - {{ $jurnal->jam_selesai }}
                                        </small>
                                    </td>
                                    <td>
                                        <strong>{{ Str::limit($jurnal->kegiatan, 50) }}</strong>
                                        @if($jurnal->deskripsi)
                                            <br><small class="text-muted">{{ Str::limit($jurnal->deskripsi, 60) }}</small>
                                        @endif                                    </td>
                                    <td class="text-center">
                                        @if($jurnal->status_validasi)
                                            @if($jurnal->status_validasi == 'valid')
                                                <span class="label label-success">
                                                    <i class="fa fa-check"></i> Valid
                                                </span>
                                            @elseif($jurnal->status_validasi == 'tidak_valid')
                                                <span class="label label-danger">
                                                    <i class="fa fa-times"></i> Tidak Valid
                                                </span>
                                            @elseif($jurnal->status_validasi == 'revisi')
                                                <span class="label label-warning">
                                                    <i class="fa fa-edit"></i> Perlu Revisi
                                                </span>
                                            @endif
                                        @else
                                            <span class="label label-default">
                                                <i class="fa fa-clock-o"></i> Menunggu
                                            </span>                                        @endif
                                    </td>                                    @if(Auth::user()->role == 'guru')
                                        <td class="text-center">
                                            @if(!$jurnal->status_validasi || $jurnal->status_validasi == 'revisi')
                                                <div class="btn-group-vertical" style="width: 100%;">
                                                    <button class="btn btn-success btn-xs validate-btn" 
                                                            data-id="{{ $jurnal->id }}" 
                                                            data-action="valid" 
                                                            title="Terima Jurnal"
                                                            onclick="console.log('ACC clicked for jurnal {{ $jurnal->id }}')">
                                                        <i class="fa fa-check"></i> ACC
                                                    </button>
                                                    <button class="btn btn-warning btn-xs validate-btn" 
                                                            data-id="{{ $jurnal->id }}" 
                                                            data-action="revisi" 
                                                            title="Minta Revisi"
                                                            onclick="console.log('Revisi clicked for jurnal {{ $jurnal->id }}')">
                                                        <i class="fa fa-edit"></i> Revisi
                                                    </button>
                                                    <button class="btn btn-danger btn-xs validate-btn" 
                                                            data-id="{{ $jurnal->id }}" 
                                                            data-action="tidak_valid" 
                                                            title="Tolak Jurnal"
                                                            onclick="console.log('Tolak clicked for jurnal {{ $jurnal->id }}')">
                                                        <i class="fa fa-times"></i> Tolak
                                                    </button>
                                                </div>
                                            @elseif($jurnal->status_validasi == 'valid')
                                                <span class="label label-success">
                                                    <i class="fa fa-check"></i> Sudah Valid
                                                </span>
                                            @elseif($jurnal->status_validasi == 'tidak_valid')
                                                <span class="label label-danger">
                                                    <i class="fa fa-times"></i> Sudah Ditolak
                                                </span>
                                                <br><small>
                                                    <button class="btn btn-warning btn-xs validate-btn" 
                                                            data-id="{{ $jurnal->id }}" 
                                                            data-action="revisi" 
                                                            title="Ubah ke Revisi">
                                                        <i class="fa fa-edit"></i> Ubah ke Revisi
                                                    </button>
                                                </small>
                                            @endif
                                        </td>
                                    @endif
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('jurnal.show', $jurnal->id) }}" class="btn btn-info btn-xs" title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>                                            @if(Auth::user()->role == 'siswa')
                                                <a href="{{ route('jurnal.edit', $jurnal->id) }}" class="btn btn-warning btn-xs" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('jurnal.destroy', $jurnal->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-xs" title="Hapus" 
                                                            onclick="return confirm('Yakin hapus jurnal ini?')">
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
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#jurnal-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "order": [[ 
                @if(Auth::user()->role != 'siswa') 2 @else 1 @endif, 
                "desc" 
            ]]        });

        // AJAX Validation for Jurnal - Use delegation from document
        $(document).on('click', '.validate-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var jurnalId = $(this).data('id');
            var action = $(this).data('action');
            var button = $(this);
            var originalHtml = button.html();
            
            console.log('Button clicked:', {
                jurnalId: jurnalId,
                action: action,
                buttonExists: button.length > 0
            });
            
            // Simple confirm for testing
            if (confirm('Apakah Anda yakin ingin ' + action + ' jurnal ini?')) {
                button.prop('disabled', true);
                button.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                
                $.ajax({
                    url: '/jurnal/' + jurnalId + '/validate',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status_validasi: action,
                        catatan_validasi: 'Validasi melalui sistem'
                    },
                    success: function(response) {
                        alert('Berhasil! Jurnal berhasil divalidasi');
                        location.reload();
                    },
                    error: function(xhr) {
                        button.prop('disabled', false);
                        button.html(originalHtml);
                        
                        var errorMsg = 'Terjadi kesalahan saat validasi';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMsg = xhr.responseJSON.error;
                        }
                        
                        alert('Error: ' + errorMsg);
                        console.log('Error response:', xhr);
                    }
                });
            }
            
            return false;
        });

        // Debug info
        setTimeout(function() {
            console.log('Validate buttons found after DOM ready:', $('.validate-btn').length);
            $('.validate-btn').each(function(i) {
                console.log('Button ' + i + ':', {
                    id: $(this).data('id'),
                    action: $(this).data('action'),
                    visible: $(this).is(':visible'),
                    enabled: !$(this).prop('disabled')
                });
            });
        }, 1000);
    });
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.min.css') }}">
<style>
.small-box {
    border-radius: 3px;
    position: relative;
    display: block;
    margin-bottom: 20px;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}

.small-box > .inner {
    padding: 10px;
}

.small-box > .small-box-footer {
    position: relative;
    text-align: center;
    padding: 3px 0;
    color: #fff;
    color: rgba(255,255,255,0.8);
    display: block;
    z-index: 10;
    background: rgba(0,0,0,0.1);
    text-decoration: none;
}

.small-box .icon {
    -webkit-transition: all .3s linear;
    -o-transition: all .3s linear;
    transition: all .3s linear;
    position: absolute;
    top: -10px;
    right: 10px;
    z-index: 0;
    font-size: 90px;
    color: rgba(0,0,0,0.15);
}

.small-box p {
    font-size: 15px;
}

.small-box p > small {
    display: block;
    color: #f9f9f9;
    font-size: 13px;
    margin-top: 5px;
}

.small-box h3 {
    font-size: 38px;
    font-weight: bold;
    margin: 0 0 10px 0;
    white-space: nowrap;
    padding: 0;
}

/* Validasi button styles */
.validate-btn {
    margin-bottom: 2px !important;
    cursor: pointer !important;
    border: 1px solid transparent !important;
    display: inline-block !important;
    padding: 1px 5px !important;
    font-size: 12px !important;
    line-height: 1.5 !important;
    border-radius: 3px !important;
    text-align: center !important;
    white-space: nowrap !important;
    vertical-align: middle !important;
    user-select: none !important;
    text-decoration: none !important;
}

.validate-btn:hover {
    opacity: 0.8 !important;
    transform: scale(1.02) !important;
}

.validate-btn:active {
    transform: scale(0.98) !important;
}

.btn-group-vertical .btn {
    width: 100% !important;
}

.btn-group-vertical .validate-btn:first-child {
    border-top-left-radius: 3px !important;
    border-top-right-radius: 3px !important;
}

.btn-group-vertical .validate-btn:last-child {
    border-bottom-left-radius: 3px !important;
    border-bottom-right-radius: 3px !important;
}

/* Ensure buttons are clickable */
td .btn-group-vertical {
    position: relative !important;
    z-index: 10 !important;
}

/* Override any DataTable styling that might interfere */
.dataTables_wrapper .validate-btn {
    pointer-events: auto !important;
}

/* Debug helper */
.validate-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: transparent;
    z-index: -1;
}
</style>
@endpush