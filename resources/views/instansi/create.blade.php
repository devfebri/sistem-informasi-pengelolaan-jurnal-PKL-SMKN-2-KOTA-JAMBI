<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\instansi\create.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        Tambah Instansi
        <small>Form tambah instansi PKL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('instansi.index') }}"><i class="fa fa-dashboard"></i> Instansi</a></li>
        <li class="active">Tambah</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Tambah Instansi</h3>
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
                <form action="{{ route('instansi.store') }}" method="POST">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nama">Nama Instansi</label>
                            <input type="text" name="nama" class="form-control" required value="{{ old('nama') }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" name="alamat" class="form-control" required value="{{ old('alamat') }}">
                        </div>
                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input type="number" name="telepon" class="form-control" value="{{ old('telepon') }}">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('instansi.index') }}" class="btn btn-default">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection