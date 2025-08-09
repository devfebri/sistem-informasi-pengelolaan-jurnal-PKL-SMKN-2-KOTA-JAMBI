<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\jurnal\create.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-plus"></i> Tambah Jurnal PKL
        <small>Form tambah jurnal kegiatan PKL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('jurnal.index') }}"><i class="fa fa-book"></i> Jurnal PKL</a></li>
        <li class="active"><i class="fa fa-plus"></i> Tambah Jurnal</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-edit"></i> Form Tambah Jurnal PKL</h3>
                </div>
                <form action="{{ route('jurnal.store') }}" method="POST" id="jurnalForm">
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

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="callout callout-info">
                                    <h4><i class="fa fa-info"></i> Informasi:</h4>
                                    Isi jurnal PKL Anda dengan lengkap dan jelas. Jurnal akan divalidasi oleh guru pembimbing setelah disimpan.
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('tanggal') ? 'has-error' : '' }}">
                            <label for="tanggal"><i class="fa fa-calendar"></i> Tanggal Kegiatan *</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" required 
                                   value="{{ old('tanggal', date('Y-m-d')) }}">
                            @if($errors->has('tanggal'))
                                <span class="help-block">{{ $errors->first('tanggal') }}</span>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('jam_mulai') ? 'has-error' : '' }}">
                                    <label for="jam_mulai"><i class="fa fa-clock-o"></i> Jam Mulai *</label>
                                    <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" required 
                                           value="{{ old('jam_mulai') }}">
                                    @if($errors->has('jam_mulai'))
                                        <span class="help-block">{{ $errors->first('jam_mulai') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('jam_selesai') ? 'has-error' : '' }}">
                                    <label for="jam_selesai"><i class="fa fa-clock-o"></i> Jam Selesai *</label>
                                    <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" required 
                                           value="{{ old('jam_selesai') }}">
                                    @if($errors->has('jam_selesai'))
                                        <span class="help-block">{{ $errors->first('jam_selesai') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('kegiatan') ? 'has-error' : '' }}">
                            <label for="kegiatan"><i class="fa fa-tasks"></i> Kegiatan *</label>
                            <textarea name="kegiatan" id="kegiatan" class="form-control" rows="4" required 
                                      placeholder="Jelaskan kegiatan yang dilakukan secara ringkas dan jelas...">{{ old('kegiatan') }}</textarea>
                            <small class="text-muted">
                                <i class="fa fa-info-circle"></i> 
                                Maksimal 500 karakter. Contoh: "Membantu admin dalam mengentry data karyawan baru"
                            </small>
                            @if($errors->has('kegiatan'))
                                <span class="help-block">{{ $errors->first('kegiatan') }}</span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('deskripsi') ? 'has-error' : '' }}">
                            <label for="deskripsi"><i class="fa fa-file-text-o"></i> Deskripsi Detail (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="6" 
                                      placeholder="Jelaskan detail kegiatan, alat/software yang digunakan, hasil yang dicapai, kendala yang dihadapi, dll...">{{ old('deskripsi') }}</textarea>
                            <small class="text-muted">
                                <i class="fa fa-lightbulb-o"></i> 
                                Maksimal 1000 karakter. Isi deskripsi yang lengkap akan membantu guru dalam memberikan penilaian.
                            </small>
                            @if($errors->has('deskripsi'))
                                <span class="help-block">{{ $errors->first('deskripsi') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-save"></i> Simpan Jurnal
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('jurnal.index') }}" class="btn btn-default btn-block">
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
    // Character counter for textarea
    $('#kegiatan').on('input', function() {
        const maxLength = 500;
        const currentLength = $(this).val().length;
        const remaining = maxLength - currentLength;
        
        if (!$(this).next('.char-counter').length) {
            $(this).after('<small class="char-counter text-muted"></small>');
        }
        
        $(this).next('.char-counter').text(remaining + ' karakter tersisa');
        
        if (remaining < 0) {
            $(this).next('.char-counter').removeClass('text-muted').addClass('text-danger');
        } else {
            $(this).next('.char-counter').removeClass('text-danger').addClass('text-muted');
        }
    });
    
    $('#deskripsi').on('input', function() {
        const maxLength = 1000;
        const currentLength = $(this).val().length;
        const remaining = maxLength - currentLength;
        
        if (!$(this).next('.char-counter').length) {
            $(this).after('<small class="char-counter text-muted"></small>');
        }
        
        $(this).next('.char-counter').text(remaining + ' karakter tersisa');
        
        if (remaining < 0) {
            $(this).next('.char-counter').removeClass('text-muted').addClass('text-danger');
        } else {
            $(this).next('.char-counter').removeClass('text-danger').addClass('text-muted');
        }
    });
    
    // Trigger initial count
    $('#kegiatan, #deskripsi').trigger('input');
});
</script>
@endpush

@push('styles')
<style>
.callout {
    margin: 20px 0;
    padding: 20px;
    border-left: 5px solid #eee;
    border-radius: 3px;
}

.callout.callout-info {
    border-left-color: #3c8dbc;
    background-color: #d9edf7;
}

.char-counter {
    display: block;
    margin-top: 5px;
}
</style>
@endpush