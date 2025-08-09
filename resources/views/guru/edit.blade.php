@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        Edit Guru
        <small>Form edit data guru</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('guru.index') }}"><i class="fa fa-dashboard"></i> Guru</a></li>
        <li class="active">Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Edit Guru</h3>
                </div>
                <form action="{{ route('guru.update', $guru->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="box-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" required value="{{ old('name', $guru->name) }}">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" required value="{{ old('username', $guru->username) }}">
                        </div>
                        <div class="form-group">
                            <label for="nip">NIP (Opsional)</label>
                            <input type="text" name="nip" class="form-control" value="{{ old('nip', $guru->nip) }}" placeholder="Nomor Induk Pegawai">
                        </div>                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" required value="{{ old('email', $guru->email) }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Nomor HP (Opsional)</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $guru->phone) }}" placeholder="Contoh: 08123456789">
                        </div>
                        <div class="form-group">
                            <label for="gender">Jenis Kelamin</label>
                            <select name="gender" class="form-control">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L" {{ old('gender', $guru->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender', $guru->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-warning">Update</button>
                        <a href="{{ route('guru.index') }}" class="btn btn-default">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
