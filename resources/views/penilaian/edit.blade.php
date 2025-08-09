<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\penilaian\edit.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-edit"></i> Edit Validasi Jurnal
        <small>Form edit validasi jurnal harian siswa</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('penilaian.index') }}"><i class="fa fa-check-circle"></i> Validasi Jurnal</a></li>
        <li class="active"><i class="fa fa-edit"></i> Edit Validasi</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-edit"></i> Form Edit Validasi Jurnal</h3>
                </div>
                <form action="{{ route('penilaian.update', $penilaian->id) }}" method="POST" id="editValidasiForm">
                    @csrf
                    @method('PUT')
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

                        <!-- Info Jurnal -->
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="callout callout-info">
                                    <h4><i class="fa fa-info"></i> Informasi Jurnal:</h4>
                                    <strong>Siswa:</strong> {{ $penilaian->jurnal->user->name ?? '-' }}<br>
                                    <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($penilaian->jurnal->tanggal)->format('d M Y') }}<br>
                                    <strong>Kegiatan:</strong> {{ $penilaian->jurnal->kegiatan ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('status_validasi') ? 'has-error' : '' }}">
                            <label for="status_validasi"><i class="fa fa-check-circle"></i> Status Validasi *</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="radio">
                                        <label class="text-success">
                                            <input type="radio" name="status_validasi" value="valid" 
                                                   {{ old('status_validasi', $penilaian->status_validasi) == 'valid' ? 'checked' : '' }}>
                                            <strong><i class="fa fa-check"></i> Valid</strong>
                                            <br><small>Jurnal sesuai dengan standar dan dapat diterima</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="radio">
                                        <label class="text-warning">
                                            <input type="radio" name="status_validasi" value="revisi" 
                                                   {{ old('status_validasi', $penilaian->status_validasi) == 'revisi' ? 'checked' : '' }}>
                                            <strong><i class="fa fa-edit"></i> Perlu Revisi</strong>
                                            <br><small>Jurnal perlu diperbaiki dengan catatan yang diberikan</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="radio">
                                        <label class="text-danger">
                                            <input type="radio" name="status_validasi" value="tidak_valid" 
                                                   {{ old('status_validasi', $penilaian->status_validasi) == 'tidak_valid' ? 'checked' : '' }}>
                                            <strong><i class="fa fa-times"></i> Tidak Valid</strong>
                                            <br><small>Jurnal tidak memenuhi standar yang ditetapkan</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @if($errors->has('status_validasi'))
                                <span class="help-block">{{ $errors->first('status_validasi') }}</span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('catatan_validasi') ? 'has-error' : '' }}">
                            <label for="catatan_validasi"><i class="fa fa-comment"></i> Catatan Validasi</label>
                            <textarea name="catatan_validasi" id="catatan_validasi" class="form-control" rows="4" 
                                      placeholder="Berikan catatan, saran, atau perbaikan yang diperlukan...">{{ old('catatan_validasi', $penilaian->catatan_validasi) }}</textarea>
                            <small class="text-muted">
                                <i class="fa fa-lightbulb-o"></i> 
                                Berikan feedback yang konstruktif untuk membantu siswa mengembangkan kemampuan.
                            </small>
                            @if($errors->has('catatan_validasi'))
                                <span class="help-block">{{ $errors->first('catatan_validasi') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-warning btn-block">
                                    <i class="fa fa-save"></i> Update Validasi
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('penilaian.index') }}" class="btn btn-default btn-block">
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
    // Show/hide catatan based on status
    $('input[name="status_validasi"]').change(function() {
        const status = $(this).val();
        const catatanField = $('#catatan_validasi');
        
        if (status === 'valid') {
            catatanField.attr('placeholder', 'Berikan apresiasi atau catatan positif (opsional)...');
        } else if (status === 'revisi') {
            catatanField.attr('placeholder', 'Jelaskan bagian mana yang perlu diperbaiki dan bagaimana cara memperbaikinya...');
        } else if (status === 'tidak_valid') {
            catatanField.attr('placeholder', 'Jelaskan alasan mengapa jurnal tidak valid dan apa yang harus dilakukan...');
        }
    });
    
    // Trigger change event on page load to set proper placeholder
    $('input[name="status_validasi"]:checked').trigger('change');
});
</script>
@endpush

@push('styles')
<style>
.radio label {
    font-weight: normal;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.radio label:hover {
    background-color: #f9f9f9;
}

.radio input[type="radio"]:checked + strong {
    color: inherit;
}

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
</style>
@endpush