<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - {{ $gaji->karyawan->nama }}</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h2 {
            margin: 0;
            color: #2563eb;
            font-size: 22px;
        }

        .header p {
            color: #555;
            font-size: 14px;
        }

        .info table, .rincian table {
            width: 100%;
            border-collapse: collapse;
        }

        .info td, .rincian td {
            padding: 6px 4px;
            font-size: 14px;
        }

        .rincian td:nth-child(2) {
            text-align: right;
        }

        .section-title {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 15px;
            color: #1e40af;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 4px;
        }

        .total {
            margin-top: 25px;
            background: #2563eb;
            color: white;
            text-align: center;
            padding: 15px;
            font-weight: bold;
            border-radius: 4px;
            font-size: 16px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 13px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h2>Slip Gaji Karyawan</h2>
            <p>Periode: {{ \Carbon\Carbon::parse($gaji->periode)->translatedFormat('F Y') }}</p>
        </div>

        <!-- Informasi Karyawan -->
        <div class="section-title">Informasi Karyawan</div>
        <table class="info">
            <tr>
                <td><strong>Nama</strong></td>
                <td>: {{ $gaji->karyawan->nama }}</td>
            </tr>
            <tr>
                <td><strong>Divisi</strong></td>
                <td>: {{ $gaji->karyawan->divisi }}</td>
            </tr>
            <tr>
                <td><strong>Jabatan</strong></td>
                <td>: {{ $gaji->karyawan->jabatan->jabatan ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Rating</strong></td>
                <td>: {{ $gaji->karyawan->rating->rating ?? '-' }} ({{ ($gaji->karyawan->rating->presentase_bonus ?? 0) * 100 }}%)</td>
            </tr>
        </table>

        <!-- Rincian Gaji -->
        <div class="section-title">Rincian Pendapatan</div>
        <table class="rincian">
            <tr>
                <td>Gaji Pokok</td>
                <td>Rp {{ number_format($gaji->karyawan->jabatan->gaji_pokok ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tunjangan</td>
                <td>Rp {{ number_format($gaji->total_tunjangan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Bonus (Rating {{ $gaji->karyawan->rating->rating ?? '-' }})</td>
                <td>Rp {{ number_format($gaji->total_bonus, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Lembur ({{ $gaji->lama_lembur }} jam)</td>
                <td>Rp {{ number_format($gaji->total_lembur, 0, ',', '.') }}</td>
            </tr>
        </table>

        <!-- Total Pendapatan -->
        <div class="total">
            TOTAL PENDAPATAN: Rp {{ number_format($gaji->total_pendapatan, 0, ',', '.') }}
        </div>

        <!-- Footer -->
        <div class="footer">
            Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}<br>
            Sistem Manajemen Gaji — Multi-Auth
        </div>
    </div>
</body>
</html>
