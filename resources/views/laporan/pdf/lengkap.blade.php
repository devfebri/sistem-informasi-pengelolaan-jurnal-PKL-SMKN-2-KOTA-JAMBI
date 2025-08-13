<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan PKL Lengkap</title>
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
            font-size: 24px;
            font-weight: bold;
            color: #333;
            display: block;
        }
        .stats-label {
            font-size: 11px;
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
            padding: 8px;
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
        .two-column {
            width: 100%;
        }
        .two-column td {
            width: 50%;
            vertical-align: top;
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
        <h1>LAPORAN PKL LENGKAP</h1>
        <h2>SMK Negeri 2 Kota Jambi</h2>
    </div>

    <div class="period">
        Periode: {{ date('d/m/Y', strtotime($tanggalMulai)) }} - {{ date('d/m/Y', strtotime($tanggalSelesai)) }}
    </div>

    <!-- Statistik Umum -->
    <div class="section-title">STATISTIK UMUM</div>
    <div class="stats-grid">
        <div class="stats-row">
            <div class="stats-cell">
                <span class="stats-number">{{ $totalJurnal }}</span>
                <div class="stats-label">Total Jurnal</div>
            </div>
            <div class="stats-cell">
                <span class="stats-number">{{ $totalSiswa }}</span>
                <div class="stats-label">Total Siswa</div>
            </div>
            <div class="stats-cell">
                <span class="stats-number">{{ $totalGuru }}</span>
                <div class="stats-label">Total Guru</div>
            </div>
            <div class="stats-cell">
                <span class="stats-number">{{ $totalInstansi }}</span>
                <div class="stats-label">Total Instansi</div>
            </div>
        </div>
    </div>

    <!-- Status Validasi -->
    <div class="section-title">STATUS VALIDASI JURNAL</div>
    <table>
        <tr>
            <th width="40%">Status</th>
            <th width="20%">Jumlah</th>
            <th width="40%">Persentase</th>
        </tr>
        <tr>
            <td><span class="status-valid">Valid</span></td>
            <td>{{ $jurnalValid }}</td>
            <td>{{ $totalJurnal > 0 ? number_format(($jurnalValid / $totalJurnal) * 100, 1) : 0 }}%</td>
        </tr>
        <tr>
            <td><span class="status-revisi">Revisi</span></td>
            <td>{{ $jurnalRevisi }}</td>
            <td>{{ $totalJurnal > 0 ? number_format(($jurnalRevisi / $totalJurnal) * 100, 1) : 0 }}%</td>
        </tr>
        <tr>
            <td><span class="status-tidak-valid">Tidak Valid</span></td>
            <td>{{ $jurnalTidakValid }}</td>
            <td>{{ $totalJurnal > 0 ? number_format(($jurnalTidakValid / $totalJurnal) * 100, 1) : 0 }}%</td>
        </tr>
        <tr>
            <td><span class="status-belum-validasi">Belum Validasi</span></td>
            <td>{{ $jurnalBelumValidasi }}</td>
            <td>{{ $totalJurnal > 0 ? number_format(($jurnalBelumValidasi / $totalJurnal) * 100, 1) : 0 }}%</td>
        </tr>
    </table>

    <!-- Data Per Instansi dan Guru -->
    <table class="two-column">
        <tr>
            <td>
                <div class="section-title">JURNAL PER INSTANSI</div>
                <table>
                    <tr>
                        <th>Instansi</th>
                        <th>Jumlah</th>
                    </tr>
                    @forelse($jurnalPerInstansi as $instansi => $jumlah)
                        <tr>
                            <td>{{ $instansi }}</td>
                            <td>{{ $jumlah }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">Tidak ada data</td>
                        </tr>
                    @endforelse
                </table>
            </td>
            <td>
                <div class="section-title">JURNAL PER GURU</div>
                <table>
                    <tr>
                        <th>Guru Pembimbing</th>
                        <th>Jumlah</th>
                    </tr>
                    @forelse($jurnalPerGuru as $guru => $jumlah)
                        <tr>
                            <td>{{ $guru }}</td>
                            <td>{{ $jumlah }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">Tidak ada data</td>
                        </tr>
                    @endforelse
                </table>
            </td>
        </tr>
    </table>

    @if($penilaianBerkala->count() > 0)
    <div class="page-break"></div>
    
    <!-- Penilaian Berkala -->
    <div class="section-title">PENILAIAN BERKALA TERBARU ({{ $totalPenilaian }} Total)</div>
    <table>
        <tr>
            <th width="15%">Tanggal</th>
            <th width="25%">Siswa</th>
            <th width="25%">Guru Penilai</th>
            <th width="20%">Periode</th>
            <th width="15%">Nilai</th>
        </tr>
        @foreach($penilaianBerkala->take(20) as $penilaian)
            <tr>
                <td>{{ is_object($penilaian->tanggal_penilaian) ? $penilaian->tanggal_penilaian->format('d/m/Y') : date('d/m/Y', strtotime($penilaian->tanggal_penilaian)) }}</td>
                <td>{{ $penilaian->siswa->name ?? 'N/A' }}</td>
                <td>{{ $penilaian->guru->name ?? 'N/A' }}</td>
                <td>{{ $penilaian->periode_penilaian }}</td>
                <td>{{ $penilaian->nilai }}</td>
            </tr>
        @endforeach
    </table>
    @endif

    @if($jurnalTerbaru->count() > 0)
    <!-- Jurnal Terbaru -->
    <div class="section-title">JURNAL TERBARU</div>
    <table>
        <tr>
            <th width="12%">Tanggal</th>
            <th width="20%">Siswa</th>
            <th width="20%">Instansi</th>
            <th width="33%">Kegiatan</th>
            <th width="15%">Status</th>
        </tr>
        @foreach($jurnalTerbaru->take(25) as $jurnal)
            <tr>
                <td>{{ is_object($jurnal->tanggal) ? $jurnal->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($jurnal->tanggal)) }}</td>
                <td>{{ $jurnal->siswa->name ?? 'N/A' }}</td>
                <td>{{ $jurnal->siswa->instansi->nama ?? 'N/A' }}</td>
                <td>{{ Str::limit($jurnal->deskripsi, 60) }}</td>
                <td>
                    @php
                        $status = $jurnal->penilaian->first()?->status_validasi ?? 'belum_validasi';
                    @endphp
                    <span class="status-{{ str_replace('_', '-', $status) }}">
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </span>
                </td>
            </tr>
        @endforeach
    </table>
    @endif

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>
