<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\jurnal\index.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        Data Jurnal PKL
        <small>Daftar Jurnal Siswa</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Jurnal PKL</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Daftar Jurnal</h3>
                    @if(auth()->user()->role=='siswa')
                    <a href="{{ route('jurnal.create') }}" class="btn btn-primary btn-sm pull-right">Tambah Jurnal</a>
                    @elseif(auth()->user()->role=='guru')
                    <a href="{{ route('penilaian.create') }}" class="btn btn-primary btn-sm pull-right" style="margin-right:5px;">Tambah Penilaian @if($jurnals->where('nilai',null)->count()!=0) <span class="badge badge-success">{{ $jurnals->where('nilai',null)->count() }}</span>@endif</a>

                    @endif
                </div>
                <div class="box-body">
                    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
                    <table id="jurnal-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kegiatan</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>File</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jurnals as $key => $jurnal)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $jurnal->tanggal }}</td>
                                <td>{{ $jurnal->kegiatan }}</td>
                                
                                <td>{{ $jurnal->jam_mulai }}</td>       
                                <td>{{ $jurnal->jam_selesai }}</td>
                                <td>
                                    @if($jurnal->file_jurnal)
                                        <a href="{{ asset('storage/'.$jurnal->file_jurnal) }}" target="_blank" class="btn btn-xs btn-success">Download</a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    

                                    @if($jurnal->nilai!=null)
                                    <b>{{ $jurnal->nilai }}</b>

                                    @else
                                    <span class="label label-{{ $jurnal->status == 'menunggu' ? 'warning' : ($jurnal->status == 'disetujui' ? 'success' : 'danger') }}">
                                        {{ ucfirst($jurnal->status) }}
                                        
                                    </span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('jurnal.show', $jurnal->id) }}" class="btn btn-info btn-xs">Detail</a>
                                    @if(auth()->user()->role=='siswa' && $jurnal->status=='menunggu')
                                    <a href="{{ route('jurnal.edit', $jurnal->id) }}" class="btn btn-warning btn-xs">Edit</a>
                                    <form action="{{ route('jurnal.destroy', $jurnal->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Yakin hapus data?')">Hapus</button>
                                    </form>
                                    @endif
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
        $('#jurnal-table').DataTable();
    });
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.min.css') }}">
@endpush