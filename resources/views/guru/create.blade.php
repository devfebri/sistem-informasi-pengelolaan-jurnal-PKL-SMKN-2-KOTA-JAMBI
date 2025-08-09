@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-user-plus"></i> Tambah Guru
        <small>Form tambah guru baru</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('guru.index') }}"><i class="fa fa-users"></i> Guru</a></li>
        <li class="active"><i class="fa fa-plus"></i> Tambah</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-edit"></i> Form Tambah Guru</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <form action="{{ route('guru.store') }}" method="POST">
                    @csrf
                    <div class="box-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="fa fa-ban"></i> Terjadi Kesalahan!</h4>
                                <ul style="margin-bottom: 0;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Personal Information -->
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-primary"><i class="fa fa-user"></i> Informasi Personal</h4>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name"><i class="fa fa-user text-blue"></i> Nama Lengkap *</label>
                                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}" placeholder="Masukkan nama lengkap">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username"><i class="fa fa-at text-green"></i> Username *</label>
                                    <input type="text" name="username" class="form-control" required value="{{ old('username') }}" placeholder="Masukkan username">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nip"><i class="fa fa-id-card text-yellow"></i> NIP (Opsional)</label>
                                    <input type="text" name="nip" class="form-control" value="{{ old('nip') }}" placeholder="Nomor Induk Pegawai">
                                    <small class="text-muted">Kosongkan jika belum memiliki NIP</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender"><i class="fa fa-venus-mars text-red"></i> Jenis Kelamin</label>
                                    <select name="gender" class="form-control">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-primary"><i class="fa fa-phone"></i> Informasi Kontak</h4>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email"><i class="fa fa-envelope text-blue"></i> Email *</label>
                                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="contoh@email.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone"><i class="fa fa-phone text-green"></i> Nomor HP (Opsional)</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="08123456789">
                                </div>
                            </div>
                        </div>

                        <!-- Security -->
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-primary"><i class="fa fa-lock"></i> Keamanan</h4>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password"><i class="fa fa-lock text-red"></i> Password *</label>
                                    <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('guru.index') }}" class="btn btn-default btn-block">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-save"></i> Simpan Data
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .text-primary {
        color: #3c8dbc !important;
    }
    .form-group label {
        font-weight: 600;
    }
</style>
@endpush
