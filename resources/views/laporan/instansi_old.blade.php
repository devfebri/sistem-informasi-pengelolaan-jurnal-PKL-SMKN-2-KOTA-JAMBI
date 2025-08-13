@extends('layouts.master')
@section('title', 'Laporan Per Instansi')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="card-title">
                                <i class="fas fa-building mr-2"></i>
                                Laporan Per Instansi
                            </h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('laporan.index') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left mr-1"></i>Kembali
                            </a>
                            @if($instansi)
                                <a href="{{ route('laporan.instansi', array_merge(request()->all(), ['download' => 'pdf'])) }}" 
                                   class="btn btn-danger">
                                    <i class="fas fa-file-pdf mr-1"></i>Download PDF
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('laporan.instansi') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="instansi_id">Pilih Instansi</label>
                                <select name="instansi_id" id="instansi_id" class="form-control" required>
                                    <option value="">-- Pilih Instansi --</option>
                                    @foreach($instansiList as $inst)
                                        <option value="{{ $inst->id }}" {{ request('instansi_id') == $inst->id ? 'selected' : '' }}>
                                            {{ $inst->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="tanggal_mulai">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" 
                                       class="form-control" value="{{ $tanggalMulai }}">
                            </div>
                            <div class="col-md-3">
                                <label for="tanggal_selesai">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" 
                                       class="form-control" value="{{ $tanggalSelesai }}">
                            </div>
                            <div class="col-md-3">
                                <label>&nbsp;</label><br>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search mr-1"></i>Lihat Laporan
                                </button>
                            </div>
                        </div>
                    </form>

                    @if($instansi)
                        <!-- Informasi Instansi -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h4>Informasi Instansi</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td width="30%"><strong>Nama Instansi:</strong></td>
                                                        <td>{{ $instansi->nama }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Alamat:</strong></td>
                                                        <td>{{ $instansi->alamat }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td width="30%"><strong>No. Telepon:</strong></td>
                                                        <td>{{ $instansi->telepon ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Email:</strong></td>
                                                        <td>{{ $instansi->email ?? '-' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistik Instansi -->
                        <div class="row mb-4">
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{ $statistik['total_siswa'] }}</h3>
                                        <p>Total Siswa</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{ $statistik['total_jurnal'] }}</h3>
                                        <p>Total Jurnal</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-book"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>{{ $statistik['jurnal_valid'] }}</h3>
                                        <p>Jurnal Valid</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>{{ $statistik['jurnal_revisi'] }}</h3>
                                        <p>Perlu Revisi</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Daftar Siswa -->
                        @if($siswaList->count() > 0)
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Daftar Siswa PKL ({{ $siswaList->count() }} Siswa)</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Siswa</th>
                                                        <th>NISN</th>
                                                        <th>Guru Pembimbing</th>
                                                        <th>Email</th>
                                                        <th>No. Telepon</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($siswaList as $index => $siswa)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $siswa->name }}</td>
                                                            <td>{{ $siswa->nisn }}</td>
                                                            <td>{{ $siswa->guru->name ?? 'Belum ditentukan' }}</td>
                                                            <td>{{ $siswa->email }}</td>
                                                            <td>{{ $siswa->phone ?? '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Status Validasi Jurnal -->
                        @if($jurnals->count() > 0)
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Status Validasi Jurnal</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="info-box bg-success mb-3">
                                            <span class="info-box-icon"><i class="fas fa-check"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Valid</span>
                                                <span class="info-box-number">{{ $statistik['jurnal_valid'] }}</span>
                                            </div>
                                        </div>
                                        <div class="info-box bg-warning mb-3">
                                            <span class="info-box-icon"><i class="fas fa-edit"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Revisi</span>
                                                <span class="info-box-number">{{ $statistik['jurnal_revisi'] }}</span>
                                            </div>
                                        </div>
                                        <div class="info-box bg-danger">
                                            <span class="info-box-icon"><i class="fas fa-times"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Tidak Valid</span>
                                                <span class="info-box-number">{{ $statistik['jurnal_tidak_valid'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Aktivitas Jurnal Per Bulan</h4>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="monthlyChart" width="400" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Riwayat Jurnal -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Jurnal Terbaru dari Instansi Ini</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="12%">Tanggal</th>
                                                        <th width="20%">Siswa</th>
                                                        <th width="35%">Kegiatan</th>
                                                        <th width="18%">Waktu</th>
                                                        <th width="15%">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($jurnals->take(20) as $jurnal)
                                                        <tr>
                                                            <td>{{ is_object($jurnal->tanggal) ? $jurnal->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($jurnal->tanggal)) }}</td>
                                                            <td>{{ $jurnal->siswa->name ?? 'N/A' }}</td>
                                                            <td>{{ Str::limit($jurnal->deskripsi, 60) }}</td>
                                                            <td>{{ $jurnal->waktu_mulai }} - {{ $jurnal->waktu_selesai }}</td>
                                                            <td>
                                                                @php
                                                                    $status = $jurnal->penilaian->first()?->status_validasi ?? 'belum_validasi';
                                                                @endphp
                                                                <span class="badge badge-{{ 
                                                                    $status == 'valid' ? 'success' : 
                                                                    ($status == 'revisi' ? 'warning' : 
                                                                    ($status == 'tidak_valid' ? 'danger' : 'secondary')) 
                                                                }}">
                                                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center">Tidak ada data jurnal</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        @if($jurnals->count() > 20)
                                            <p class="text-muted text-center mt-3">
                                                Menampilkan 20 jurnal terbaru dari {{ $jurnals->count() }} total jurnal
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($siswaList->count() == 0)
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Tidak ada siswa yang terdaftar di instansi ini.
                                </div>
                            </div>
                        </div>
                        @endif

                    @else
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    Silakan pilih instansi terlebih dahulu untuk melihat laporan.
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@if($instansi && $jurnals->count() > 0)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    
    // Group jurnal by month
    const monthlyData = {};
    @foreach($jurnals as $jurnal)
        const month = '{{ is_object($jurnal->tanggal) ? $jurnal->tanggal->format("Y-m") : date("Y-m", strtotime($jurnal->tanggal)) }}';
        monthlyData[month] = (monthlyData[month] || 0) + 1;
    @endforeach
    
    const months = Object.keys(monthlyData).sort();
    const counts = months.map(month => monthlyData[month]);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months.map(month => {
                const [year, monthNum] = month.split('-');
                const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 
                                  'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
                return monthNames[parseInt(monthNum) - 1] + ' ' + year;
            }),
            datasets: [{
                label: 'Jumlah Jurnal',
                data: counts,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endif
@endpush
@endsection
