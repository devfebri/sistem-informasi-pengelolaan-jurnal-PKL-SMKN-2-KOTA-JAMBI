<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\penilaian\index.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        Data Penilaian Jurnal PKL
        <small>Daftar Penilaian oleh Guru</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Penilaian</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Daftar Penilaian</h3>
                    <a href="{{ route('penilaian.create') }}" class="btn btn-primary btn-sm pull-right">Tambah Penilaian</a>
                </div>
                <div class="box-body">
                    <table id="penilaian-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Tanggal Jurnal</th>
                                <th>Nilai</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penilaians as $key => $penilaian)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $penilaian->jurnal->user->name ?? '-' }}</td>
                                <td>{{ $penilaian->jurnal->tanggal ?? '-' }}</td>
                                <td>{{ $penilaian->nilai }}</td>
                                <td>{{ $penilaian->catatan }}</td>
                                <td>
                                    <a href="{{ route('penilaian.show', $penilaian->id) }}" class="btn btn-info btn-xs">Detail</a>
                                    <a href="{{ route('penilaian.edit', $penilaian->id) }}" class="btn btn-warning btn-xs">Edit</a>
                                    <form action="{{ route('penilaian.destroy', $penilaian->id) }}" method="POST" style="display:inline;">
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
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#penilaian-table').DataTable();
    });
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.min.css') }}">

@endpush