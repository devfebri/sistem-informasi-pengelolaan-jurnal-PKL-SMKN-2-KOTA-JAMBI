<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan PKL - {{ $instansi->nama }}</title>
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
        .instansi-info {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
        }
        .instansi-info table {
            width: 100%;
        }
        .instansi-info td {
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
        <h1>LAPORAN PKL PER INSTANSI</h1>
        <h2>SMK Negeri 2 Kota Jambi</h2>
    </div>

    <div class="period">
        Periode: {{ date('d/m/Y', strtotime($tanggalMulai)) }} - {{ date('d/m/Y', strtotime($tanggalSelesai)) }}
    </div>

    <!-- Informasi Instansi -->
    <div class="section-title">INFORMASI INSTANSI</div>
    <div class="instansi-info">
        <table>
            <tr>
                <td width="20%"><strong>Nama Instansi</strong></td>
                <td width="30%">: {{ $instansi->nama }}</td>
                <td width="20%"><strong>No. Telepon</strong></td>
                <td width="30%">: {{ $instansi->telepon ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Alamat</strong></td>
                <td>: {{ $instansi->alamat }}</td>
                <td><strong>Email</strong></td>
                <td>: {{ $instansi->email ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- Statistik -->
    <div class="section-title">STATISTIK INSTANSI</div>
    <div class="stats-grid">
        <div class="stats-row">
            <div class="stats-cell">
                <span class="stats-number">{{ $statistik['total_siswa'] }}</span>
                <div class="stats-label">Total Siswa</div>
            </div>
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
        </div>
    </div>

    @if($siswaInstansi->count() > 0)
    <!-- Daftar Siswa -->
    <div class="section-title">DAFTAR SISWA PKL ({{ $siswaInstansi->count() }} Siswa)</div>
    <table>
        <tr>
            <th width="5%">No</th>
            <th width="25%">Nama Siswa</th>
            <th width="15%">NISN</th>
            <th width="25%">Guru Pembimbing</th>
            <th width="20%">Email</th>
            <th width="10%">No. Telepon</th>
        </tr>
        @foreach($siswaInstansi as $index => $siswa)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $siswa->name }}</td>
                <td>{{ $siswa->nisn }}</td>
                <td>{{ $siswa->guru->name ?? 'Belum ditentukan' }}</td>
                <td>{{ $siswa->email }}</td>
                <td>{{ $siswa->phone ?? '-' }}</td>
            </tr>
        @endforeach
    </table>
    @endif

    @if($jurnalTerbaru->count() > 0)
    @if($siswaInstansi->count() > 10)
    <div class="page-break"></div>
    @endif
    
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
            <td>{{ $statistik['jurnal_valid'] }}</td>
            <td>{{ $statistik['total_jurnal'] > 0 ? number_format(($statistik['jurnal_valid'] / $statistik['total_jurnal']) * 100, 1) : 0 }}%</td>
        </tr>
        <tr>
            <td><span class="status-revisi">Revisi</span></td>
            <td>{{ $statistik['jurnal_revisi'] }}</td>
            <td>{{ $statistik['total_jurnal'] > 0 ? number_format(($statistik['jurnal_revisi'] / $statistik['total_jurnal']) * 100, 1) : 0 }}%</td>
        </tr>
        <tr>
            <td><span class="status-tidak-valid">Tidak Valid</span></td>
            <td>{{ $statistik['jurnal_tidak_valid'] }}</td>
            <td>{{ $statistik['total_jurnal'] > 0 ? number_format(($statistik['jurnal_tidak_valid'] / $statistik['total_jurnal']) * 100, 1) : 0 }}%</td>
        </tr>
    </table>

    <!-- Jurnal Terbaru -->
    <div class="section-title">JURNAL TERBARU</div>
    <table>
        <tr>
            <th width="12%">Tanggal</th>
            <th width="20%">Siswa</th>
            <th width="35%">Kegiatan</th>
            <th width="18%">Waktu</th>
            <th width="15%">Status</th>
        </tr>
        @foreach($jurnalTerbaru->take(25) as $jurnal)
            <tr>
                <td>{{ is_object($jurnal->tanggal) ? $jurnal->tanggal->format('d/m/Y') : date('d/m/Y', strtotime($jurnal->tanggal)) }}</td>
                <td>{{ $jurnal->siswa->name ?? 'N/A' }}</td>
                <td>{{ Str::limit($jurnal->deskripsi, 60) }}</td>
                <td>{{ $jurnal->waktu_mulai }} - {{ $jurnal->waktu_selesai }}</td>
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

    @if($jurnalTerbaru->count() > 25)
    <p style="text-align: center; color: #666; font-style: italic;">
        Menampilkan 25 jurnal terbaru dari {{ $jurnalTerbaru->count() }} total jurnal
    </p>
    @endif
    @endif

    @if($siswaInstansi->count() == 0)
    <div class="section-title">INFORMASI</div>
    <p style="text-align: center; color: #666; font-style: italic;">
        Tidak ada siswa yang terdaftar di instansi ini.
    </p>
    @endif

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>
