@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-user-plus"></i> Tambah Siswa
        <small>Form tambah siswa PKL baru</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('siswa.index') }}"><i class="fa fa-graduation-cap"></i> Siswa</a></li>
        <li class="active"><i class="fa fa-plus"></i> Tambah</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-edit"></i> Form Tambah Siswa</h3>
                </div>
                <form action="{{ route('siswa.store') }}" method="POST" id="siswaForm">
                    @csrf
                    <div class="box-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-ban"></i> Oops! Ada kesalahan:</h4>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Section: Data Pribadi -->
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 class="box-title"><i class="fa fa-user text-blue"></i> Data Pribadi</h4>
                                <hr style="margin-top: 5px;">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label for="name"><i class="fa fa-user"></i> Nama Lengkap *</label>
                                    <input type="text" name="name" id="name" class="form-control" required 
                                           value="{{ old('name') }}" placeholder="Masukkan nama lengkap siswa">
                                    @if($errors->has('name'))
                                        <span class="help-block">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                                    <label for="username"><i class="fa fa-at"></i> Username *</label>
                                    <input type="text" name="username" id="username" class="form-control" required 
                                           value="{{ old('username') }}" placeholder="Masukkan username unik">
                                    @if($errors->has('username'))
                                        <span class="help-block">{{ $errors->first('username') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('nisn') ? 'has-error' : '' }}">
                                    <label for="nisn"><i class="fa fa-id-card"></i> NISN *</label>
                                    <input type="text" name="nisn" id="nisn" class="form-control" required 
                                           value="{{ old('nisn') }}" placeholder="Masukkan NISN siswa" maxlength="10">
                                    @if($errors->has('nisn'))
                                        <span class="help-block">{{ $errors->first('nisn') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
                                    <label for="gender"><i class="fa fa-venus-mars"></i> Jenis Kelamin</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @if($errors->has('gender'))
                                        <span class="help-block">{{ $errors->first('gender') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Section: Data Kontak -->
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 class="box-title"><i class="fa fa-phone text-green"></i> Data Kontak</h4>
                                <hr style="margin-top: 5px;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                    <label for="email"><i class="fa fa-envelope"></i> Email *</label>
                                    <input type="email" name="email" id="email" class="form-control" required 
                                           value="{{ old('email') }}" placeholder="Masukkan alamat email">
                                    @if($errors->has('email'))
                                        <span class="help-block">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                                    <label for="phone"><i class="fa fa-phone"></i> Nomor HP</label>
                                    <input type="text" name="phone" id="phone" class="form-control" 
                                           value="{{ old('phone') }}" placeholder="Contoh: 08123456789">
                                    <small class="text-muted">Opsional - Format: 08xxxxxxxxxx</small>
                                    @if($errors->has('phone'))
                                        <span class="help-block">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Section: Data PKL -->
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 class="box-title"><i class="fa fa-graduation-cap text-yellow"></i> Data PKL</h4>
                                <hr style="margin-top: 5px;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('guru_id') ? 'has-error' : '' }}">
                                    <label for="guru_id"><i class="fa fa-user-circle"></i> Guru Pembimbing</label>
                                    <select name="guru_id" id="guru_id" class="form-control">
                                        <option value="">-- Pilih Guru Pembimbing --</option>
                                        @foreach($gurus as $guru)
                                            <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                                                {{ $guru->name }} {{ $guru->nip ? '('.$guru->nip.')' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('guru_id'))
                                        <span class="help-block">{{ $errors->first('guru_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('instansi_id') ? 'has-error' : '' }}">
                                    <label for="instansi_id"><i class="fa fa-building"></i> Instansi PKL</label>
                                    <select name="instansi_id" id="instansi_id" class="form-control">
                                        <option value="">-- Pilih Instansi PKL --</option>
                                        @foreach($instansis as $instansi)
                                            <option value="{{ $instansi->id }}" {{ old('instansi_id') == $instansi->id ? 'selected' : '' }}>
                                                {{ $instansi->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('instansi_id'))
                                        <span class="help-block">{{ $errors->first('instansi_id') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Section: Keamanan -->
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 class="box-title"><i class="fa fa-lock text-red"></i> Keamanan Akun</h4>
                                <hr style="margin-top: 5px;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                    <label for="password"><i class="fa fa-key"></i> Password *</label>
                                    <input type="password" name="password" id="password" class="form-control" required 
                                           placeholder="Masukkan password">
                                    <small class="text-muted">Minimal 8 karakter</small>
                                    @if($errors->has('password'))
                                        <span class="help-block">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation"><i class="fa fa-key"></i> Konfirmasi Password *</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="form-control" required placeholder="Ulangi password">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-save"></i> Simpan Data Siswa
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('siswa.index') }}" class="btn btn-default btn-block">
                                    <i class="fa fa-arrow-left"></i> Kembali ke Daftar
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Validasi NISN hanya angka
    $('#nisn').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Validasi nomor HP
    $('#phone').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Form validation
    $('#siswaForm').on('submit', function(e) {
        var password = $('#password').val();
        var confirm_password = $('#password_confirmation').val();
        
        if (password !== confirm_password) {
            e.preventDefault();
            alert('Password dan konfirmasi password tidak sama!');
            return false;
        }
        
        if (password.length < 8) {
            e.preventDefault();
            alert('Password harus minimal 8 karakter!');
            return false;
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.box-title {
    margin-bottom: 10px;
}
.form-group label {
    font-weight: 600;
}
.form-group .fa {
    margin-right: 5px;
}
.help-block {
    font-size: 12px;
}
hr {
    border-color: #f4f4f4;
}
</style>
@endpush