<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\penilaian\create.blade.php -->
@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-check-circle"></i> Validasi Jurnal Harian
        <small>Form validasi jurnal harian siswa PKL</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('penilaian.index') }}"><i class="fa fa-check-circle"></i> Validasi Jurnal</a></li>
        <li class="active"><i class="fa fa-plus"></i> Validasi Baru</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-edit"></i> Form Validasi Jurnal Harian</h3>
                </div>
                <form action="{{ route('penilaian.store') }}" method="POST" id="validasiForm">
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
                                    Validasi jurnal harian dilakukan untuk memastikan kegiatan PKL siswa sesuai dengan standar dan dapat dipertanggungjawabkan.
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('jurnal_id') ? 'has-error' : '' }}">
                            <label for="jurnal_id"><i class="fa fa-book"></i> Pilih Jurnal Siswa *</label>
                            <select name="jurnal_id" id="jurnal_id" class="form-control" required>
                                <option value="">-- Pilih Jurnal yang akan divalidasi --</option>
                                @foreach($jurnals as $jurnal)
                                    <option value="{{ $jurnal->id }}" {{ old('jurnal_id') == $jurnal->id ? 'selected' : '' }}>
                                        <strong>{{ $jurnal->user->name }}</strong> - 
                                        {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }} - 
                                        {{ Str::limit($jurnal->kegiatan, 50) }}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->has('jurnal_id'))
                                <span class="help-block">{{ $errors->first('jurnal_id') }}</span>
                            @endif
                            @if($jurnals->count() == 0)
                                <small class="text-info">
                                    <i class="fa fa-info-circle"></i> 
                                    Semua jurnal siswa bimbingan Anda sudah divalidasi.
                                </small>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('status_validasi') ? 'has-error' : '' }}">
                            <label for="status_validasi"><i class="fa fa-check-circle"></i> Status Validasi *</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="radio">
                                        <label class="text-success">
                                            <input type="radio" name="status_validasi" value="valid" 
                                                   {{ old('status_validasi') == 'valid' ? 'checked' : '' }}>
                                            <strong><i class="fa fa-check"></i> Valid</strong>
                                            <br><small>Jurnal sesuai dengan standar dan dapat diterima</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="radio">
                                        <label class="text-warning">
                                            <input type="radio" name="status_validasi" value="revisi" 
                                                   {{ old('status_validasi') == 'revisi' ? 'checked' : '' }}>
                                            <strong><i class="fa fa-edit"></i> Perlu Revisi</strong>
                                            <br><small>Jurnal perlu diperbaiki dengan catatan yang diberikan</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="radio">
                                        <label class="text-danger">
                                            <input type="radio" name="status_validasi" value="tidak_valid" 
                                                   {{ old('status_validasi') == 'tidak_valid' ? 'checked' : '' }}>
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
                                      placeholder="Berikan catatan, saran, atau perbaikan yang diperlukan...">{{ old('catatan_validasi') }}</textarea>
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
                                <button type="submit" class="btn btn-primary btn-block" 
                                        {{ $jurnals->count() == 0 ? 'disabled' : '' }}>
                                    <i class="fa fa-check"></i> Validasi Jurnal
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
        const catatanGroup = $('#catatan_validasi').closest('.form-group');
        const catatanField = $('#catatan_validasi');
        
        if (status === 'valid') {
            catatanField.attr('placeholder', 'Berikan apresiasi atau catatan positif (opsional)...');
        } else if (status === 'revisi') {
            catatanField.attr('placeholder', 'Jelaskan bagian mana yang perlu diperbaiki dan bagaimana cara memperbaikinya...');
        } else if (status === 'tidak_valid') {
            catatanField.attr('placeholder', 'Jelaskan alasan mengapa jurnal tidak valid dan apa yang harus dilakukan...');
        }
    });

    // Preview jurnal details
    $('#jurnal_id').change(function() {
        const selectedOption = $(this).find('option:selected');
        if (selectedOption.val()) {
            // You can add AJAX call here to show jurnal preview
        }
    });
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
                        <a href="{{ route('jurnal.index') }}" class="btn btn-default">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection