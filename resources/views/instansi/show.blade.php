<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\instansi\show.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        Detail Instansi
        <small>Informasi Instansi PKL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('instansi.index') }}"><i class="fa fa-dashboard"></i> Instansi</a></li>
        <li class="active">Detail</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Instansi</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama Instansi</th>
                            <td>{{ $instansi->nama }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $instansi->alamat }}</td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>{{ $instansi->telepon }}</td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <a href="{{ route('instansi.index') }}" class="btn btn-default">Kembali</a>
                    <a href="{{ route('instansi.edit', $instansi->id) }}" class="btn btn-warning">Edit</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection