@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-users"></i> Data Guru
        <small>Daftar Guru Pembimbing PKL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-users"></i> Guru</li>
    </ol>
</section>

<section class="content">
    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>{{ $gurus->count() }}</h3>
                    <p>Total Guru</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $gurus->where('nip', '!=', null)->count() }}</h3>
                    <p>Guru Verified</p>
                </div>
                <div class="icon">
                    <i class="fa fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $gurus->where('gender', 'L')->count() }}</h3>
                    <p>Guru Laki-laki</p>
                </div>
                <div class="icon">
                    <i class="fa fa-male"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $gurus->where('gender', 'P')->count() }}</h3>
                    <p>Guru Perempuan</p>
                </div>
                <div class="icon">
                    <i class="fa fa-female"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-list"></i> Daftar Guru</h3>
                    <div class="box-tools pull-right">
                        <a href="{{ route('guru.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Tambah Guru
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-check"></i> {{ session('success') }}
                        </div>
                    @endif                    <div class="table-responsive">
                        <table id="guru-table" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="bg-primary">
                                    <th width="5%"><i class="fa fa-hashtag"></i> No</th>
                                    <th><i class="fa fa-user"></i> Nama</th>
                                    <th><i class="fa fa-at"></i> Username</th>
                                    <th><i class="fa fa-id-card"></i> NIP</th>
                                    <th><i class="fa fa-envelope"></i> Email</th>
                                    <th><i class="fa fa-phone"></i> No. HP</th>
                                    <th><i class="fa fa-venus-mars"></i> Gender</th>
                                    <th width="15%"><i class="fa fa-cogs"></i> Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gurus as $key => $guru)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>
                                        <div style="display: flex; align-items: center;">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($guru->name) }}&background={{ $guru->gender == 'L' ? '3c8dbc' : 'e91e63' }}&color=fff&size=32" 
                                                 class="img-circle" alt="Avatar" style="margin-right: 10px;">
                                            <div>
                                                <strong>{{ $guru->name }}</strong>
                                                @if($guru->nip)
                                                    <br><small class="text-success"><i class="fa fa-check-circle"></i> Verified</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td><code>{{ $guru->username }}</code></td>
                                    <td>
                                        @if($guru->nip)
                                            <span class="label label-info">{{ $guru->nip }}</span>
                                        @else
                                            <span class="text-muted">Belum ada</span>
                                        @endif
                                    </td>
                                    <td><a href="mailto:{{ $guru->email }}">{{ $guru->email }}</a></td>
                                    <td>
                                        @if($guru->phone)
                                            <a href="tel:{{ $guru->phone }}"><i class="fa fa-phone text-green"></i> {{ $guru->phone }}</a>
                                        @else
                                            <span class="text-muted">Belum ada</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($guru->gender == 'L')
                                            <span class="label label-info"><i class="fa fa-male"></i> Laki-laki</span>
                                        @elseif($guru->gender == 'P')
                                            <span class="label label-warning"><i class="fa fa-female"></i> Perempuan</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('guru.show', $guru->id) }}" class="btn btn-info btn-xs" title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('guru.edit', $guru->id) }}" class="btn btn-warning btn-xs" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-xs" onclick="deleteGuru({{ $guru->id }})" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $guru->id }}" action="{{ route('guru.destroy', $guru->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#guru-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            },
            "pageLength": 10,
            "order": [[1, "asc"]],
            "columnDefs": [
                { "orderable": false, "targets": [7] }
            ]
        });
    });

    function deleteGuru(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus data guru ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap.min.css">
@endpush
