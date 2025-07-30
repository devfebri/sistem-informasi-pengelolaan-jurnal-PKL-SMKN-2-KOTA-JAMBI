<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\user\show.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        Detail User
        <small>Informasi User</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('user.index') }}"><i class="fa fa-dashboard"></i> User</a></li>
        <li class="active">Detail</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail User</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>{{ ucfirst($user->role) }}</td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td>{{ $user->username }}</td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <a href="{{ route('user.index') }}" class="btn btn-default">Kembali</a>
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection