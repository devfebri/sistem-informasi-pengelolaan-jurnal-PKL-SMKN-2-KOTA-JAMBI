@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        Data Instansi PKL
        <small>Daftar Instansi Tempat PKL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Instansi</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Daftar Instansi</h3>
                    <a href="{{ route('instansi.create') }}" class="btn btn-primary btn-sm pull-right">Tambah Instansi</a>
                </div>
                <div class="box-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <table id="instansi-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Instansi</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($instansis as $key => $instansi)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $instansi->nama }}</td>
                                <td>{{ $instansi->alamat }}</td>
                                <td>{{ $instansi->telepon }}</td>
                                <td>
                                    <a href="{{ route('instansi.show', $instansi->id) }}" class="btn btn-info btn-xs">Detail</a>
                                    <a href="{{ route('instansi.edit', $instansi->id) }}" class="btn btn-warning btn-xs">Edit</a>
                                    <form action="{{ route('instansi.destroy', $instansi->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Yakin hapus data?')">Hapus</button>
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
</section>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#instansi-table').DataTable();
    });
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap.min.css">
@endpush

