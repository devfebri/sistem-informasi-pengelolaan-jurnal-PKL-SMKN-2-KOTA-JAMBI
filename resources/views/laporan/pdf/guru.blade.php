<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan PKL Per Guru - {{ $guru->name ?? 'Nama Guru' }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #605ca8;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #605ca8;
            margin: 0 0 10px 0;
            font-size: 24px;
            font-weight: bold;
        }
        
        .header h2 {
            color: #666;
            margin: 0 0 5px 0;
            font-size: 18px;
            font-weight: normal;
        }
        
        .header p {
            margin: 5px 0;
            color: #888;
        }
        
        .info-section {
            margin-bottom: 25px;
            background: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #605ca8;
        }
        
        .info-section h3 {
            margin: 0 0 15px 0;
            color: #605ca8;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            width: 30%;
            padding: 5px 10px 5px 0;
            font-weight: bold;
            color: #555;
        }
        
        .info-value {
            display: table-cell;
            padding: 5px 0;
            color: #333;
        }
        
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }
        
        .stats-row {
            display: table-row;
        }
        
        .stat-box {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 15px;
            margin: 5px;
            background: linear-gradient(135deg, #605ca8, #9b59b6);
            color: white;
            border-radius: 5px;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 11px;
            text-transform: uppercase;
            opacity: 0.9;
        }
        
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        
        .section-title {
            background: #605ca8;
            color: white;
            padding: 10px 15px;
            margin: 0 0 15px 0;
            font-size: 14px;
            font-weight: bold;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }
        
        table th {
            background: #f8f9fa;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            color: #555;
        }
        
        table td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            vertical-align: top;
        }
        
        table tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .text-center {
            text-align: center;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 3px;
            color: white;
        }
        
        .badge-success { background: #28a745; }
        .badge-warning { background: #ffc107; color: #333; }
        .badge-danger { background: #dc3545; }
        .badge-info { background: #17a2b8; }
        .badge-default { background: #6c757d; }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        .no-data {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 20px;
        }
        
        /* Print specific styles */
        @media print {
            body { margin: 0; }
            .page-break { page-break-before: always; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN PKL PER GURU</h1>
        <h2>SMKN 2 KOTA JAMBI</h2>
        <p><strong>Guru:</strong> {{ $guru->name ?? 'Nama Guru' }}</p>
        @if(isset($tanggalMulai) && isset($tanggalSelesai) && $tanggalMulai && $tanggalSelesai)
            <p><strong>Periode:</strong> {{ date('d/m/Y', strtotime($tanggalMulai)) }} - {{ date('d/m/Y', strtotime($tanggalSelesai)) }}</p>
        @endif
        <p><strong>Tanggal Cetak:</strong> {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Informasi Guru -->
    <div class="info-section">
        <h3>INFORMASI GURU</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nama Lengkap:</div>
                <div class="info-value">{{ $guru->name ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">NIP:</div>
                <div class="info-value">{{ $guru->nip ?? 'Belum ada NIP' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $guru->email ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">No. Telepon:</div>
                <div class="info-value">{{ $guru->phone ?? 'Belum ada nomor' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Jenis Kelamin:</div>
                <div class="info-value">{{ $guru->gender ? ucfirst($guru->gender) : 'Belum diset' }}</div>
            </div>
        </div>
    </div>

    <!-- Statistik Bimbingan -->
    <div class="stats-grid">
        <div class="stats-row">
            <div class="stat-box">
                <span class="stat-number">{{ $totalSiswaBimbingan ?? 0 }}</span>
                <span class="stat-label">Siswa Bimbingan</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $totalJurnalBimbingan ?? 0 }}</span>
                <span class="stat-label">Total Jurnal</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $jurnalValidBimbingan ?? 0 }}</span>
                <span class="stat-label">Jurnal Valid</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ isset($averageNilaiBimbingan) ? number_format($averageNilaiBimbingan, 1) : '0.0' }}</span>
                <span class="stat-label">Rata-rata Nilai</span>
            </div>
        </div>
    </div>

    <!-- Daftar Siswa Bimbingan -->
    <div class="section">
        <div class="section-title">DAFTAR SISWA BIMBINGAN ({{ $totalSiswaBimbingan ?? 0 }} Siswa)</div>
        
        @if(isset($siswaBimbingan) && $siswaBimbingan->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 25%;">Nama Siswa</th>
                        <th style="width: 15%;">NISN</th>
                        <th style="width: 25%;">Instansi PKL</th>
                        <th style="width: 10%;">Total Jurnal</th>
                        <th style="width: 10%;">Jurnal Valid</th>
                        <th style="width: 10%;">Rata-rata Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswaBimbingan as $index => $siswa)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $siswa->name }}</td>
                            <td>{{ $siswa->nisn }}</td>
                            <td>{{ optional($siswa->instansi)->nama ?? 'Belum ditentukan' }}</td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ $siswa->jurnal_count ?? 0 }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success">{{ $siswa->jurnal_valid_count ?? 0 }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-{{ $siswa->avg_nilai >= 80 ? 'success' : ($siswa->avg_nilai >= 70 ? 'warning' : 'danger') }}">
                                    {{ $siswa->avg_nilai ? number_format($siswa->avg_nilai, 1) : '0.0' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">Tidak ada siswa bimbingan</div>
        @endif
    </div>

    <!-- Jurnal Terbaru -->
    <div class="section page-break">
        <div class="section-title">JURNAL TERBARU SISWA BIMBINGAN</div>
        
        @if(isset($jurnalSiswaBimbingan) && $jurnalSiswaBimbingan->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 12%;">Tanggal</th>
                        <th style="width: 18%;">Siswa</th>
                        <th style="width: 20%;">Kegiatan</th>
                        <th style="width: 30%;">Deskripsi</th>
                        <th style="width: 15%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jurnalSiswaBimbingan as $index => $jurnal)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ is_object($jurnal->tanggal) ? $jurnal->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($jurnal->tanggal)) }}</td>
                            <td>{{ optional($jurnal->siswa)->name ?? 'N/A' }}</td>
                            <td>{{ $jurnal->kegiatan }}</td>
                            <td>{{ Str::limit($jurnal->deskripsi, 100) }}</td>
                            <td class="text-center">
                                @php
                                    $status = $jurnal->penilaian->first()?->status_validasi ?? 'belum_validasi';
                                @endphp
                                <span class="badge badge-{{ 
                                    $status == 'valid' ? 'success' : 
                                    ($status == 'revisi' ? 'warning' : 
                                    ($status == 'tidak_valid' ? 'danger' : 'default')) 
                                }}">
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">Tidak ada data jurnal dalam periode ini</div>
        @endif
    </div>

    <!-- Penilaian Terbaru -->
    <div class="section">
        <div class="section-title">PENILAIAN TERBARU SISWA BIMBINGAN</div>
        
        @if(isset($penilaianSiswaBimbingan) && $penilaianSiswaBimbingan->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 12%;">Tanggal</th>
                        <th style="width: 18%;">Siswa</th>
                        <th style="width: 15%;">Periode</th>
                        <th style="width: 15%;">Penilai</th>
                        <th style="width: 10%;">Nilai</th>
                        <th style="width: 25%;">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penilaianSiswaBimbingan as $index => $penilaian)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ is_object($penilaian->tanggal_penilaian) ? $penilaian->tanggal_penilaian->format('d/m/Y') : date('d/m/Y', strtotime($penilaian->tanggal_penilaian)) }}</td>
                            <td>{{ optional($penilaian->siswa)->name ?? 'N/A' }}</td>
                            <td>{{ $penilaian->periode_penilaian }}</td>
                            <td>{{ optional($penilaian->guru)->name ?? 'N/A' }}</td>
                            <td class="text-center">
                                <span class="badge badge-{{ $penilaian->nilai >= 80 ? 'success' : ($penilaian->nilai >= 70 ? 'warning' : 'danger') }}">
                                    {{ $penilaian->nilai }}
                                </span>
                            </td>
                            <td>{{ $penilaian->catatan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">Tidak ada data penilaian dalam periode ini</div>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>SMKN 2 KOTA JAMBI</strong></p>
        <p>Sistem Informasi Pengelolaan Jurnal PKL</p>
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }} | Halaman ini digenerate otomatis oleh sistem</p>
    </div>
</body>
</html>
