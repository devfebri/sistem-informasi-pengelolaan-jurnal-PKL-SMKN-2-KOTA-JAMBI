<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\penilaian\show.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        Detail Penilaian
        <small>Informasi Penilaian Jurnal PKL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('penilaian.index') }}"><i class="fa fa-dashboard"></i> Penilaian</a></li>
        <li class="active">Detail</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Penilaian</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama Siswa</th>
                            <td>{{ $penilaian->jurnal->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Jurnal</th>
                            <td>{{ $penilaian->jurnal->tanggal ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Nilai</th>
                            <td>{{ $penilaian->nilai }}</td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $penilaian->catatan }}</td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <a href="{{ route('penilaian.index') }}" class="btn btn-default">Kembali</a>
                    <a href="{{ route('penilaian.edit', $penilaian->id) }}" class="btn btn-warning">Edit</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection