<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\penilaian\edit.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        Edit Penilaian
        <small>Form edit penilaian jurnal PKL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('penilaian.index') }}"><i class="fa fa-dashboard"></i> Penilaian</a></li>
        <li class="active">Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Edit Penilaian</h3>
                </div>
                <form action="{{ route('penilaian.update', $penilaian->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="box-body">
                        <div class="form-group">
                            <label for="jurnal_id">Jurnal Siswa</label>
                            <select name="jurnal_id" class="form-control" disabled>
                                <option value="{{ $penilaian->jurnal->id }}">{{ $penilaian->jurnal->user->name }} - {{ $penilaian->jurnal->tanggal }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nilai">Nilai</label>
                            <input type="number" name="nilai" class="form-control" min="0" max="100" required value="{{ old('nilai', $penilaian->nilai) }}">
                        </div>
                        <div class="form-group">
                            <label for="catatan">Catatan</label>
                            <textarea name="catatan" class="form-control">{{ old('catatan', $penilaian->catatan) }}</textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-warning">Update</button>
                        <a href="{{ route('penilaian.index') }}" class="btn btn-default">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection