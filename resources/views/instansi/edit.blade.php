<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\instansi\edit.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        Edit Instansi
        <small>Form edit instansi PKL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('instansi.index') }}"><i class="fa fa-dashboard"></i> Instansi</a></li>
        <li class="active">Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Edit Instansi</h3>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('instansi.update', $instansi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nama">Nama Instansi</label>
                            <input type="text" name="nama" class="form-control" required value="{{ old('nama', $instansi->nama) }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" name="alamat" class="form-control" required value="{{ old('alamat', $instansi->alamat) }}">
                        </div>
                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $instansi->telepon) }}">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-warning">Update</button>
                        <a href="{{ route('instansi.index') }}" class="btn btn-default">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection