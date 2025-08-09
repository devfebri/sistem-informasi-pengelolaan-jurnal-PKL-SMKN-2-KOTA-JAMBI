@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-graduation-cap"></i> Detail Siswa
        <small>Informasi lengkap siswa PKL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('siswa.index') }}"><i class="fa fa-users"></i> Siswa</a></li>
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
                         src="https://ui-avatars.com/api/?name={{ urlencode($siswa->name) }}&background={{ $siswa->gender == 'L' ? '3c8dbc' : 'e91e63' }}&color=fff&size=128" 
                         alt="Foto Profil {{ $siswa->name }}">
                    <h3 class="profile-username text-center">{{ $siswa->name }}</h3>
                    <p class="text-muted text-center">
                        <i class="fa fa-graduation-cap"></i> {{ ucfirst($siswa->role) }}
                    </p>
                    
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b><i class="fa fa-id-badge text-blue"></i> NISN</b> 
                            <a class="pull-right">
                                <span class="badge bg-blue">{{ $siswa->nisn ?? 'Belum ada' }}</span>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fa fa-calendar text-green"></i> Bergabung</b> 
                            <a class="pull-right text-muted">{{ $siswa->created_at->format('M Y') }}</a>
                        </li>
                        @if($siswa->guru)
                        <li class="list-group-item">
                            <b><i class="fa fa-user-tie text-yellow"></i> Status</b> 
                            <a class="pull-right">
                                <span class="label label-success">Ada Pembimbing</span>
                            </a>
                        </li>
                        @endif
                        @if($siswa->instansi)
                        <li class="list-group-item">
                            <b><i class="fa fa-building text-red"></i> PKL</b> 
                            <a class="pull-right">
                                <span class="label label-info">Sudah Penempatan</span>
                            </a>
                        </li>
                        @endif
                    </ul>

                    <div class="row">
                        <div class="col-xs-6">
                            <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-warning btn-block">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="{{ route('siswa.index') }}" class="btn btn-default btn-block">
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
                    <li><a href="#akademik" data-toggle="tab"><i class="fa fa-school"></i> Akademik</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="info">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-blue"><i class="fa fa-user"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Nama Lengkap</span>
                                        <span class="info-box-number">{{ $siswa->name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="fa fa-at"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Username</span>
                                        <span class="info-box-number">{{ $siswa->username }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-id-badge"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">NISN</span>
                                        <span class="info-box-number">{{ $siswa->nisn ?? 'Belum ada' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-red"><i class="fa fa-venus-mars"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Jenis Kelamin</span>
                                        <span class="info-box-number">
                                            {{ $siswa->gender == 'L' ? 'Laki-laki' : ($siswa->gender == 'P' ? 'Perempuan' : 'Belum diisi') }}
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
                                        <span class="info-box-number" style="font-size: 16px;">{{ $siswa->email }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="fa fa-phone"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Nomor HP</span>
                                        <span class="info-box-number">{{ $siswa->phone ?? 'Belum diisi' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="akademik">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-tie"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Guru Pembimbing</span>
                                        <span class="info-box-number" style="font-size: 16px;">{{ $siswa->guru->name ?? 'Belum ada' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-red"><i class="fa fa-building"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Instansi PKL</span>
                                        <span class="info-box-number" style="font-size: 16px;">{{ $siswa->instansi->nama ?? 'Belum ada' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
