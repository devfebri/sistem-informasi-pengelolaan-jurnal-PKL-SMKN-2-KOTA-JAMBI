@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-user-circle"></i> Detail Guru
        <small>Informasi lengkap guru pembimbing</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('guru.index') }}"><i class="fa fa-users"></i> Guru</a></li>
        <li class="active"><i class="fa fa-eye"></i> Detail</li>
    </ol>
</section>

<section class="content">
    <!-- Profile Card -->
    <div class="row">
        <div class="col-md-4">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" 
                         src="https://ui-avatars.com/api/?name={{ urlencode($guru->name) }}&background=3c8dbc&color=fff&size=128" 
                         alt="Foto Profil {{ $guru->name }}">
                    <h3 class="profile-username text-center">{{ $guru->name }}</h3>
                    <p class="text-muted text-center">
                        <i class="fa fa-graduation-cap"></i> {{ ucfirst($guru->role) }}
                    </p>
                    
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b><i class="fa fa-users text-blue"></i> Siswa Bimbingan</b> 
                            <a class="pull-right">
                                <span class="badge bg-blue">{{ $guru->siswa->count() }}</span>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fa fa-calendar text-green"></i> Bergabung</b> 
                            <a class="pull-right text-muted">{{ $guru->created_at->format('M Y') }}</a>
                        </li>
                        @if($guru->nip)
                        <li class="list-group-item">
                            <b><i class="fa fa-id-card text-yellow"></i> Status</b> 
                            <a class="pull-right">
                                <span class="label label-success">Verified</span>
                            </a>
                        </li>
                        @endif
                    </ul>

                    <div class="row">
                        <div class="col-xs-6">
                            <a href="{{ route('guru.edit', $guru->id) }}" class="btn btn-warning btn-block">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="{{ route('guru.index') }}" class="btn btn-default btn-block">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Informasi Detail -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#info" data-toggle="tab"><i class="fa fa-info-circle"></i> Informasi</a></li>
                    <li><a href="#contact" data-toggle="tab"><i class="fa fa-phone"></i> Kontak</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="info">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-blue"><i class="fa fa-user"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Nama Lengkap</span>
                                        <span class="info-box-number">{{ $guru->name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="fa fa-at"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Username</span>
                                        <span class="info-box-number">{{ $guru->username }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-id-card"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">NIP</span>
                                        <span class="info-box-number">{{ $guru->nip ?? 'Belum ada' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-red"><i class="fa fa-venus-mars"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Jenis Kelamin</span>
                                        <span class="info-box-number">
                                            {{ $guru->gender == 'L' ? 'Laki-laki' : ($guru->gender == 'P' ? 'Perempuan' : 'Belum diisi') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="contact">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-blue"><i class="fa fa-envelope"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Email</span>
                                        <span class="info-box-number" style="font-size: 16px;">{{ $guru->email }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="fa fa-phone"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Nomor HP</span>
                                        <span class="info-box-number">{{ $guru->phone ?? 'Belum diisi' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- Daftar Siswa Bimbingan -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-users"></i> Daftar Siswa Bimbingan
                    </h3>
                    <div class="box-tools pull-right">
                        <span class="label label-success">{{ $guru->siswa->count() }} Siswa</span>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    @if($guru->siswa->count() > 0)
                        <div class="row">
                            @foreach($guru->siswa as $siswa)
                            <div class="col-md-6 col-lg-4">
                                <div class="box box-widget widget-user-2">
                                    <div class="widget-user-header bg-{{ $siswa->gender == 'L' ? 'blue' : 'pink' }}">
                                        <div class="widget-user-image">
                                            <img class="img-circle" 
                                                 src="https://ui-avatars.com/api/?name={{ urlencode($siswa->name) }}&background={{ $siswa->gender == 'L' ? '3c8dbc' : 'e91e63' }}&color=fff&size=64" 
                                                 alt="Avatar {{ $siswa->name }}">
                                        </div>
                                        <h3 class="widget-user-username">{{ $siswa->name }}</h3>
                                        <h5 class="widget-user-desc">
                                            {{ $siswa->gender == 'L' ? 'Laki-laki' : ($siswa->gender == 'P' ? 'Perempuan' : 'Siswa') }}
                                        </h5>
                                    </div>
                                    <div class="box-footer no-padding">
                                        <ul class="nav nav-stacked">
                                            <li><a href="#"><i class="fa fa-id-badge text-blue"></i> NISN <span class="pull-right text-muted">{{ $siswa->nisn ?? 'Belum ada' }}</span></a></li>
                                            <li><a href="#"><i class="fa fa-envelope text-green"></i> Email <span class="pull-right text-muted">{{ Str::limit($siswa->email, 20) }}</span></a></li>
                                            <li><a href="#"><i class="fa fa-phone text-yellow"></i> HP <span class="pull-right text-muted">{{ $siswa->phone ?? 'Belum ada' }}</span></a></li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-building text-red"></i> Instansi 
                                                    <span class="pull-right">
                                                        @if($siswa->instansi)
                                                            <span class="label label-success">{{ Str::limit($siswa->instansi->nama, 15) }}</span>
                                                        @else
                                                            <span class="label label-danger">Belum ada</span>
                                                        @endif
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="text-center" style="padding: 10px;">
                                            <a href="{{ route('siswa.show', $siswa->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye"></i> Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="callout callout-info">
                            <h4><i class="fa fa-info"></i> Informasi</h4>
                            <p>Guru ini belum membimbing siswa manapun. Siswa dapat ditugaskan melalui halaman manajemen siswa.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
