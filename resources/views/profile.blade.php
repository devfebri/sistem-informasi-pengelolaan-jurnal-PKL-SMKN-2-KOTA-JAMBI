@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        Profile Saya
        <small>Ubah data akun Anda</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Profile</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Profile</h3>
                </div>
                <div class="box-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $data->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username', $data->username) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $data->email) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Instansi</label>
                            <select name="instansi_id" class="form-control">
                                <option value="">-- Pilih Instansi --</option>
                                @foreach($instansis as $instansi)
                                <option value="{{ $instansi->id }}" {{ old('instansi_id', $data->instansi_id) == $instansi->id ? 'selected' : '' }}>
                                    {{ $instansi->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Password Baru <small>(Kosongkan jika tidak ingin ganti)</small></label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection