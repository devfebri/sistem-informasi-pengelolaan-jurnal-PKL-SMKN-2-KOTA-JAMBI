<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan PKL - {{ $siswa->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .header h2 {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #666;
        }
        .period {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #555;
        }
        .student-info {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
        }
        .student-info table {
            width: 100%;
        }
        .student-info td {
            padding: 5px 0;
            border: none;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stats-row {
            display: table-row;
        }
        .stats-cell {
            display: table-cell;
            width: 25%;
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }
        .stats-number {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            display: block;
        }
        .stats-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 11px;
        }
        td {
            font-size: 10px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .status-valid { 
            background-color: #d4edda; 
            color: #155724; 
            padding: 2px 6px; 
            border-radius: 3px;
            font-size: 9px;
        }
        .status-revisi { 
            background-color: #fff3cd; 
            color: #856404; 
            padding: 2px 6px; 
            border-radius: 3px;
            font-size: 9px;
        }
        .status-tidak-valid { 
            background-color: #f8d7da; 
            color: #721c24; 
            padding: 2px 6px; 
            border-radius: 3px;
            font-size: 9px;
        }
        .status-belum-validasi { 
            background-color: #e2e3e5; 
            color: #383d41; 
            padding: 2px 6px; 
            border-radius: 3px;
            font-size: 9px;
        }
        .nilai-tinggi {
            background-color: #d4edda;
            color: #155724;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }
        .nilai-sedang {
            background-color: #fff3cd;
            color: #856404;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }
        .nilai-rendah {
            background-color: #f8d7da;
            color: #721c24;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }
        .page-break {
            page-break-before: always;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PKL SISWA</h1>
        <h2>SMK Negeri 2 Kota Jambi</h2>
    </div>

    <div class="period">
        Periode: {{ date('d/m/Y', strtotime($tanggalMulai)) }} - {{ date('d/m/Y', strtotime($tanggalSelesai)) }}
    </div>

    <!-- Informasi Siswa -->
    <div class="section-title">INFORMASI SISWA</div>
    <div class="student-info">
        <table>
            <tr>
                <td width="20%"><strong>Nama</strong></td>
                <td width="30%">: {{ $siswa->name }}</td>
                <td width="20%"><strong>Instansi</strong></td>
                <td width="30%">: {{ $siswa->instansi->nama ?? 'Belum ditentukan' }}</td>
            </tr>
            <tr>
                <td><strong>NISN</strong></td>
                <td>: {{ $siswa->nisn }}</td>
                <td><strong>Guru Pembimbing</strong></td>
                <td>: {{ $siswa->guru->name ?? 'Belum ditentukan' }}</td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td>: {{ $siswa->email }}</td>
                <td><strong>No. Telepon</strong></td>
                <td>: {{ $siswa->phone ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- Statistik -->
    <div class="section-title">STATISTIK JURNAL</div>
    <div class="stats-grid">
        <div class="stats-row">
            <div class="stats-cell">
                <span class="stats-number">{{ $statistik['total_jurnal'] }}</span>
                <div class="stats-label">Total Jurnal</div>
            </div>
            <div class="stats-cell">
                <span class="stats-number">{{ $statistik['jurnal_valid'] }}</span>
                <div class="stats-label">Jurnal Valid</div>
            </div>
            <div class="stats-cell">
                <span class="stats-number">{{ $statistik['jurnal_revisi'] }}</span>
                <div class="stats-label">Perlu Revisi</div>
            </div>
            <div class="stats-cell">
                <span class="stats-number">{{ number_format($statistik['nilai_rata_rata'], 1) }}</span>
                <div class="stats-label">Rata-rata Nilai</div>
            </div>
        </div>
    </div>

    @if($penilaians->count() > 0)
    <!-- Penilaian Berkala -->
    <div class="section-title">RIWAYAT PENILAIAN BERKALA</div>
    <table>
        <tr>
            <th width="15%">Tanggal</th>
            <th width="25%">Guru Penilai</th>
            <th width="20%">Periode</th>
            <th width="10%">Nilai</th>
            <th width="30%">Catatan</th>
        </tr>
        @foreach($penilaians as $penilaian)
            <tr>
                <td>{{ is_object($penilaian->tanggal_penilaian) ? $penilaian->tanggal_penilaian->format('d/m/Y') : date('d/m/Y', strtotime($penilaian->tanggal_penilaian)) }}</td>
                <td>{{ $penilaian->guru->name ?? 'N/A' }}</td>
                <td>{{ $penilaian->periode_penilaian }}</td>
                <td>
                    <span class="{{ $penilaian->nilai >= 80 ? 'nilai-tinggi' : ($penilaian->nilai >= 70 ? 'nilai-sedang' : 'nilai-rendah') }}">
                        {{ $penilaian->nilai }}
                    </span>
                </td>
                <td>{{ $penilaian->catatan ?? '-' }}</td>
            </tr>
        @endforeach
    </table>
    @endif

    @if($jurnals->count() > 0)
    @if($penilaians->count() > 0)
    <div class="page-break"></div>
    @endif
    
    <!-- Riwayat Jurnal -->
    <div class="section-title">RIWAYAT JURNAL HARIAN</div>
    <table>
        <tr>
            <th width="12%">Tanggal</th>
            <th width="38%">Kegiatan</th>
            <th width="15%">Waktu</th>
            <th width="15%">Status</th>
            <th width="20%">Catatan</th>
        </tr>
        @foreach($jurnals as $jurnal)
            <tr>
                <td>{{ is_object($jurnal->tanggal) ? $jurnal->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($jurnal->tanggal)) }}</td>
                <td>{{ $jurnal->deskripsi }}</td>
                <td>{{ $jurnal->waktu_mulai }} - {{ $jurnal->waktu_selesai }}</td>
                <td>
                    @php
                        $status = $jurnal->penilaian->first()?->status_validasi ?? 'belum_validasi';
                    @endphp
                    <span class="status-{{ str_replace('_', '-', $status) }}">
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </span>
                </td>
                <td>{{ $jurnal->penilaian->first()?->catatan ?? '-' }}</td>
            </tr>
        @endforeach
    </table>
    @endif

    @if($jurnals->count() == 0 && $penilaians->count() == 0)
    <div class="section-title">INFORMASI</div>
    <p style="text-align: center; color: #666; font-style: italic;">
        Tidak ada data jurnal atau penilaian untuk siswa ini dalam periode yang dipilih.
    </p>
    @endif

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>
