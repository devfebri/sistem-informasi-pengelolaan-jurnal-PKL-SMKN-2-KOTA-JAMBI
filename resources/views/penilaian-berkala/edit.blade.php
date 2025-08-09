@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-edit"></i> Edit Penilaian Berkala
        <small>Ubah penilaian nilai berkala siswa</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('penilaian-berkala.index') }}"><i class="fa fa-star"></i> Penilaian Berkala</a></li>
        <li class="active"><i class="fa fa-edit"></i> Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-edit"></i> Form Edit Penilaian Berkala</h3>
                </div>
                
                <form action="{{ route('penilaian-berkala.update', $penilaian->id) }}" method="POST">
                    @csrf
                    @method('PUT')
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
                            <label for="siswa_info">Siswa</label>                            <div class="form-control" style="background-color: #f4f4f4; border: 1px solid #ddd;">
                                <strong>{{ $penilaian->siswa->name ?? 'N/A' }}</strong> - {{ $penilaian->siswa->nisn ?? 'N/A' }}
                            </div>
                            <p class="help-block">
                                <i class="fa fa-info-circle"></i> Data siswa tidak dapat diubah
                            </p>
                        </div>

                        <div class="form-group">
                            <label for="periode_penilaian">Periode Penilaian <span class="text-red">*</span></label>
                            <select name="periode_penilaian" id="periode_penilaian" class="form-control" required>
                                <option value="">-- Pilih Periode --</option>
                                <option value="triwulan" {{ old('periode_penilaian', $penilaian->periode_penilaian) == 'triwulan' ? 'selected' : '' }}>Triwulan (3 Bulan)</option>
                                <option value="semester" {{ old('periode_penilaian', $penilaian->periode_penilaian) == 'semester' ? 'selected' : '' }}>Semester (6 Bulan)</option>
                            </select>
                            @error('periode_penilaian')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tanggal_penilaian">Tanggal Penilaian <span class="text-red">*</span></label>
                            <input type="date" name="tanggal_penilaian" id="tanggal_penilaian" 
                                   class="form-control" value="{{ old('tanggal_penilaian', $penilaian->tanggal_penilaian) }}" required>
                            @error('tanggal_penilaian')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nilai">Nilai <span class="text-red">*</span></label>
                            <input type="number" name="nilai" id="nilai" class="form-control" 
                                   min="0" max="100" step="0.1" value="{{ old('nilai', $penilaian->nilai) }}" 
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
                                      rows="4" placeholder="Berikan catatan atau komentar untuk penilaian ini...">{{ old('catatan_nilai', $penilaian->catatan_nilai) }}</textarea>
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
                                <button type="submit" class="btn btn-warning">
                                    <i class="fa fa-save"></i> Update Penilaian
                                </button>
                                <a href="{{ route('penilaian-berkala.index') }}" class="btn btn-default">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                                <a href="{{ route('penilaian-berkala.show', $penilaian->id) }}" class="btn btn-info">
                                    <i class="fa fa-eye"></i> Lihat Detail
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
<style>
.help-block {
    margin-top: 5px;
    margin-bottom: 0;
    color: #737373;
    font-size: 12px;
}
</style>
@endpush
