<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\penilaian\create.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        Tambah Penilaian
        <small>Form tambah penilaian jurnal PKL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('penilaian.index') }}"><i class="fa fa-dashboard"></i> Penilaian</a></li>
        <li class="active">Tambah</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Tambah Penilaian</h3>
                </div>
                <form action="{{ route('penilaian.store') }}" method="POST">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="jurnal_id">Jurnal Siswa</label>
                            <select name="jurnal_id" class="form-control" required>
                                <option value="">-- Pilih Jurnal --</option>
                                @foreach($jurnals as $jurnal)
                                    <option value="{{ $jurnal->id }}">
                                        {{ $jurnal->user->name }} - {{ $jurnal->tanggal }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jurnal_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nilai">Nilai</label>
                            <input type="number" name="nilai" class="form-control" min="0" max="100" required value="{{ old('nilai') }}">
                        </div>
                        <div class="form-group">
                            <label for="catatan">Catatan</label>
                            <textarea name="catatan" class="form-control">{{ old('catatan') }}</textarea>
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