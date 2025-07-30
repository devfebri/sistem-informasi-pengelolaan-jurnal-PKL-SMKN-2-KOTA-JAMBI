<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\jurnal\edit.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        Edit Jurnal PKL
        <small>Form edit jurnal PKL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('jurnal.index') }}"><i class="fa fa-dashboard"></i> Jurnal PKL</a></li>
        <li class="active">Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Edit Jurnal</h3>
                </div>
                <form action="{{ route('jurnal.update', $jurnal->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="box-body">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required value="{{ old('tanggal', $jurnal->tanggal) }}">
                        </div>
                        <div class="form-group">
                            <label for="jam_mulai">Jam Mulai</label>
                            <input type="time" name="jam_mulai" class="form-control" required value="{{ old('jam_mulai', $jurnal->jam_mulai) }}">
                        </div>
                        <div class="form-group">
                            <label for="jam_selesai">Jam Selesai</label>
                            <input type="time" name="jam_selesai" class="form-control" required value="{{ old('jam_selesai', $jurnal->jam_selesai) }}">
                        </div>
                        <div class="form-group">
                            <label for="kegiatan">Kegiatan</label>
                            <textarea name="kegiatan" class="form-control" required>{{ old('kegiatan', $jurnal->kegiatan) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="file_jurnal">Upload File Jurnal (PDF/DOC)</label>
                            <input type="file" name="file_jurnal" class="form-control">
                            @if($jurnal->file_jurnal)
                                <p>File saat ini: <a href="{{ asset('storage/'.$jurnal->file_jurnal) }}" target="_blank">Download</a></p>
                            @endif
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-warning">Update</button>
                        <a href="{{ route('jurnal.index') }}" class="btn btn-default">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection