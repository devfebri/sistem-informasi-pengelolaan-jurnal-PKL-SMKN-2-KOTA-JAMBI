<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\jurnal\show.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        Detail Jurnal PKL
        <small>Informasi Jurnal PKL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('jurnal.index') }}"><i class="fa fa-dashboard"></i> Jurnal PKL</a></li>
        <li class="active">Detail</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Jurnal</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Tanggal</th>
                            <td>{{ $jurnal->tanggal }}</td>
                        </tr>
                        <tr>
                            <th>Kegiatan</th>
                            <td>{{ $jurnal->kegiatan }}</td>
                        </tr>
                        <tr>
                            <th>Nilai</th>
                            <td>
                                @if(isset($jurnal->penilaian) && $jurnal->penilaian->count() > 0)
                                    @foreach($jurnal->penilaian as $penilaian)
                                        <span class="label label-info">{{ $penilaian->nilai }}</span>
                                    @endforeach
                                @elseif(isset($jurnal->nilai) && $jurnal->nilai !== null)
                                    <b>{{ $jurnal->nilai }}</b>
                                @else
                                    <span class="label label-{{ $jurnal->status == 'menunggu' ? 'warning' : ($jurnal->status == 'disetujui' ? 'success' : 'danger') }}">
                                        {{ ucfirst($jurnal->status) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Jam Mulai</th>
                            <td>{{ $jurnal->jam_mulai }}</td>
                        </tr>
                        <tr>
                            <th>Jam Selesai</th>
                            <td>{{ $jurnal->jam_selesai }}</td>
                        </tr>
                        <tr>
                            <th>File Jurnal</th>
                            <td>
                                @if($jurnal->file_jurnal)
                                    <a href="{{ asset('storage/'.$jurnal->file_jurnal) }}" target="_blank" class="btn btn-xs btn-success">Download</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <a href="{{ route('jurnal.index') }}" class="btn btn-default">Kembali</a>
                    @if(auth()->user()->role=='siswa')
                    <a href="{{ route('jurnal.edit', $jurnal->id) }}" class="btn btn-warning">Edit</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection