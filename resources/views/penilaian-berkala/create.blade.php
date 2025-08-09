@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-plus"></i> Tambah Penilaian Berkala
        <small>Buat penilaian nilai berkala untuk siswa bimbingan</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('penilaian-berkala.index') }}"><i class="fa fa-star"></i> Penilaian Berkala</a></li>
        <li class="active"><i class="fa fa-plus"></i> Tambah</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-plus"></i> Form Tambah Penilaian Berkala</h3>
                </div>
                
                <form action="{{ route('penilaian-berkala.store') }}" method="POST">
                    @csrf
                    <div class="box-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                                <ul style="margin-bottom: 0;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="siswa_id">Siswa <span class="text-red">*</span></label>
                            <select name="siswa_id" id="siswa_id" class="form-control select2" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswaList as $siswa)
                                    <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                                        {{ $siswa->name }} - {{ $siswa->nisn }}
                                    </option>
                                @endforeach
                            </select>
                            @error('siswa_id')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="periode_penilaian">Periode Penilaian <span class="text-red">*</span></label>
                            <select name="periode_penilaian" id="periode_penilaian" class="form-control" required>
                                <option value="">-- Pilih Periode --</option>
                                <option value="triwulan" {{ old('periode_penilaian') == 'triwulan' ? 'selected' : '' }}>Triwulan (3 Bulan)</option>
                                <option value="semester" {{ old('periode_penilaian') == 'semester' ? 'selected' : '' }}>Semester (6 Bulan)</option>
                            </select>
                            @error('periode_penilaian')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tanggal_penilaian">Tanggal Penilaian <span class="text-red">*</span></label>
                            <input type="date" name="tanggal_penilaian" id="tanggal_penilaian" 
                                   class="form-control" value="{{ old('tanggal_penilaian', date('Y-m-d')) }}" required>
                            @error('tanggal_penilaian')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nilai">Nilai <span class="text-red">*</span></label>
                            <input type="number" name="nilai" id="nilai" class="form-control" 
                                   min="0" max="100" step="0.1" value="{{ old('nilai') }}" 
                                   placeholder="Masukkan nilai (0-100)" required>
                            <p class="help-block">
                                <i class="fa fa-info-circle"></i> Rentang nilai: 0 - 100
                            </p>
                            @error('nilai')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="catatan_nilai">Catatan Nilai</label>
                            <textarea name="catatan_nilai" id="catatan_nilai" class="form-control" 
                                      rows="4" placeholder="Berikan catatan atau komentar untuk penilaian ini...">{{ old('catatan_nilai') }}</textarea>
                            <p class="help-block">
                                <i class="fa fa-info-circle"></i> Opsional: Berikan catatan evaluasi atau feedback
                            </p>
                            @error('catatan_nilai')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Simpan Penilaian
                                </button>
                                <a href="{{ route('penilaian-berkala.index') }}" class="btn btn-default">
                                    <i class="fa fa-arrow-left"></i> Kembali
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
<script src="{{ asset('js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            placeholder: "-- Pilih Siswa --",
            allowClear: true
        });

        // Nilai validation
        $('#nilai').on('input', function() {
            var nilai = parseFloat($(this).val());
            if (nilai < 0) {
                $(this).val(0);
            } else if (nilai > 100) {
                $(this).val(100);
            }
        });
    });
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<style>
.select2-container--default .select2-selection--single {
    height: 34px;
    border: 1px solid #d2d6de;
    border-radius: 0;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 32px;
    padding-left: 12px;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 32px;
}

.help-block {
    margin-top: 5px;
    margin-bottom: 0;
    color: #737373;
    font-size: 12px;
}
</style>
@endpush
