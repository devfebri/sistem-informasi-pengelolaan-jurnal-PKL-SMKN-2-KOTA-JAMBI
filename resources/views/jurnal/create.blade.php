<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\jurnal\create.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        Tambah Jurnal PKL
        <small>Form tambah jurnal PKL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('jurnal.index') }}"><i class="fa fa-dashboard"></i> Jurnal PKL</a></li>
        <li class="active">Tambah</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Tambah Jurnal</h3>
                </div>
                <form action="{{ route('jurnal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required value="{{ old('tanggal') }}">
                        </div>
                        <div class="form-group">
                            <label for="jam_mulai">Jam Mulai</label>
                            <input type="time" name="jam_mulai" class="form-control" required value="{{ old('jam_mulai') }}">
                        </div>
                        <div class="form-group">
                            <label for="jam_selesai">Jam Selesai</label>
                            <input type="time" name="jam_selesai" class="form-control" required value="{{ old('jam_selesai') }}">
                        </div>
                        <div class="form-group">
                            <label for="kegiatan">Kegiatan</label>
                            <textarea name="kegiatan" class="form-control" required>{{ old('kegiatan') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="file_jurnal">Upload File Jurnal (PDF/DOC)</label>
                            <input type="file" name="file_jurnal" class="form-control">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('jurnal.index') }}" class="btn btn-default">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection