@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-graduation-cap"></i> Data Siswa
        <small>Manajemen data siswa PKL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-graduation-cap"></i> Siswa</li>
    </ol>
</section>

<section class="content">
    <!-- Statistik Dashboard -->
    <div class="row">
        <div class="col-lg-4 col-xs-12">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $siswas->count() }}</h3>
                    <p>Total Siswa</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="#" class="small-box-footer">Info lebih lanjut <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-xs-12">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $siswas->where('guru_id', '!=', null)->count() }}</h3>
                    <p>Sudah Dibimbing</p>
                </div>
                <div class="icon">
                    <i class="fa fa-check-circle"></i>
                </div>
                <a href="#" class="small-box-footer">Info lebih lanjut <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-xs-12">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $siswas->where('instansi_id', '!=', null)->count() }}</h3>
                    <p>Punya Instansi</p>
                </div>
                <div class="icon">
                    <i class="fa fa-building"></i>
                </div>
                <a href="#" class="small-box-footer">Info lebih lanjut <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
    </div>

    <!-- Tabel Data Siswa -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-table"></i> Daftar Siswa PKL</h3>
                    <div class="box-tools pull-right">
                        <a href="{{ route('siswa.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Tambah Siswa
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
                    
                    <div class="table-responsive">
                        <table id="siswa-table" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>NISN</th>
                                    <th>Kontak</th>
                                    <th>Gender</th>
                                    <th>Guru Pembimbing</th>
                                    <th>Instansi</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswas as $key => $siswa)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="text-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->name) }}&background=3c8dbc&color=fff&size=40" 
                                             class="img-circle" alt="Avatar" style="width: 40px; height: 40px;">
                                    </td>
                                    <td>
                                        <strong>{{ $siswa->name }}</strong><br>
                                        <small class="text-muted">{{ $siswa->username }}</small>
                                    </td>
                                    <td>
                                        @if($siswa->nisn)
                                            <span class="label label-primary">{{ $siswa->nisn }}</span>
                                        @else
                                            <span class="label label-default">Belum ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>
                                            <i class="fa fa-envelope text-blue"></i> {{ $siswa->email }}<br>
                                            <i class="fa fa-phone text-green"></i> {{ $siswa->phone ?? 'Belum diisi' }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        @if($siswa->gender == 'L')
                                            <span class="label label-info"><i class="fa fa-mars"></i> Laki-laki</span>
                                        @elseif($siswa->gender == 'P')
                                            <span class="label label-warning"><i class="fa fa-venus"></i> Perempuan</span>
                                        @else
                                            <span class="label label-default">Belum diisi</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($siswa->guru)
                                            <span class="label label-success">{{ $siswa->guru->name }}</span>
                                        @else
                                            <span class="label label-danger">Belum ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($siswa->instansi)
                                            <span class="label label-primary">{{ $siswa->instansi->nama }}</span>
                                        @else
                                            <span class="label label-default">Belum ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('siswa.show', $siswa->id) }}" class="btn btn-info btn-xs" title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-warning btn-xs" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-xs" title="Hapus" 
                                                    onclick="deleteSiswa({{ $siswa->id }}, '{{ $siswa->name }}')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                        <!-- Form hapus tersembunyi -->
                                        <form id="delete-form-{{ $siswa->id }}" action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" style="display: none;">
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
        $('#siswa-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            },
            "responsive": true,
            "autoWidth": false,
            "columnDefs": [
                { "orderable": false, "targets": [1, 8] } // Disable sorting untuk kolom foto dan aksi
            ]
        });
    });

    function deleteSiswa(id, name) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: `Apakah Anda yakin ingin menghapus siswa "${name}"?`,
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

    // Show success message if exists
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
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