<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Slip Gaji - {{ $karyawan->nama }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @page { 
            margin: 20px;
            size: A4;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            margin: 0;
            padding: 0;
            color: #1f2937;
            line-height: 1.5;
        }
        
        .container {
            max-width: 100%;
            margin: 0 auto;
            background: #ffffff;
        }
        
        /* Header Styles */
        .header {
            text-align: center;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            margin: 0;
            color: #1e40af;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        .header p {
            color: #6b7280;
            font-size: 14px;
            margin: 8px 0 0 0;
            font-weight: 500;
        }
        
        /* Section Styles */
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-weight: 600;
            color: #374151;
            margin-bottom: 15px;
            font-size: 16px;
            border-left: 4px solid #3b82f6;
            padding-left: 12px;
            background: #f8fafc;
            padding: 10px 12px;
            border-radius: 6px;
        }
        
        /* Table Styles */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .info-table th,
        .info-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            font-size: 14px;
        }
        
        .info-table th {
            background: #f9fafb;
            font-weight: 600;
            color: #374151;
            width: 35%;
        }
        
        .info-table td {
            width: 65%;
            font-weight: 500;
        }
        
        .info-table tr:last-child th,
        .info-table tr:last-child td {
            border-bottom: none;
        }
        
        /* Salary Breakdown */
        .salary-breakdown {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .breakdown-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .breakdown-item:last-child {
            border-bottom: none;
        }
        
        .breakdown-label {
            color: #6b7280;
            font-size: 14px;
        }
        
        .breakdown-value {
            font-weight: 600;
            color: #1f2937;
            font-size: 14px;
        }
        
        /* Total Section */
        .total-section {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            margin: 30px 0;
        }
        
        .total-label {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            opacity: 0.9;
        }
        
        .total-amount {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #9ca3af;
            font-size: 12px;
        }
        
        .footer strong {
            color: #3b82f6;
            font-weight: 600;
        }
        
        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            background: #10b981;
            color: white;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }
        
        /* Amount Colors */
        .amount-positive {
            color: #059669;
            font-weight: 600;
        }
        
        .amount-primary {
            color: #3b82f6;
            font-weight: 600;
        }
        
        /* Grid Layout for Company Info */
        .company-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }
        
        .company-logo {
            text-align: left;
        }
        
        .document-info {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header dengan informasi perusahaan -->
        <div class="company-info">
            <div class="company-logo">
                <h2 style="margin: 0; color: #1e40af; font-size: 20px; font-weight: 700;">COMPANY NAME</h2>
                <p style="margin: 2px 0; color: #6b7280; font-size: 12px;">Sistem Manajemen Gaji Karyawan</p>
            </div>
            <div class="document-info">
                <p style="margin: 0; color: #6b7280; font-size: 12px; font-weight: 500;">
                    ID: <strong style="color: #3b82f6;">{{ $gaji->id_gaji }}</strong>
                </p>
                <p style="margin: 2px 0; color: #6b7280; font-size: 12px;">
                    Dicetak: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>

        <!-- Header utama -->
        <div class="header">
            <h1>SLIP GAJI KARYAWAN</h1>
            <p>Periode: {{ \Carbon\Carbon::parse($gaji->periode)->translatedFormat('F Y') }}</p>
        </div>

        <!-- Informasi Karyawan -->
        <div class="section">
            <div class="section-title">Informasi Karyawan</div>
            <table class="info-table">
                <tr>
                    <th>Nama Karyawan</th>
                    <td>{{ $karyawan->nama }}</td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <td>{{ $karyawan->nama_jabatan }}</td>
                </tr>
                <tr>
                    <th>Divisi</th>
                    <td>{{ $gaji->karyawan->divisi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Rating & Bonus</th>
                    <td>
                        Rating {{ $karyawan->rating }} 
                        <span class="amount-primary">({{ round($karyawan->presentase_bonus * 100) }}%)</span>
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        {{ $gaji->karyawan->status }}
                        <span class="status-badge">Active</span>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Detail Periode & Lembur -->
        <div class="section">
            <div class="section-title">Detail Periode & Lembur</div>
            <table class="info-table">
                <tr>
                    <th>Periode Gaji</th>
                    <td>{{ \Carbon\Carbon::parse($gaji->periode)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Lama Lembur</th>
                    <td>{{ $gaji->lama_lembur }} jam</td>
                </tr>
                <tr>
                    <th>Tarif Lembur</th>
                    <td class="amount-primary">Rp {{ number_format($gaji->lembur->tarif ?? 0, 0, ',', '.') }}/jam</td>
                </tr>
                <tr>
                    <th>Tanggal Cetak</th>
                    <td>{{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}</td>
                </tr>
            </table>
        </div>

        <!-- Rincian Gaji -->
        <div class="section">
            <div class="section-title">Rincian Pendapatan</div>
            <div class="salary-breakdown">
                <div class="breakdown-item">
                    <span class="breakdown-label">Gaji Pokok</span>
                    <span class="breakdown-value amount-positive">Rp {{ number_format($karyawan->gaji_pokok ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="breakdown-item">
                    <span class="breakdown-label">Tunjangan Jabatan</span>
                    <span class="breakdown-value amount-positive">Rp {{ number_format($gaji->total_tunjangan, 0, ',', '.') }}</span>
                </div>
                <div class="breakdown-item">
                    <span class="breakdown-label">Bonus (Rating {{ $karyawan->rating }})</span>
                    <span class="breakdown-value amount-primary">Rp {{ number_format($gaji->total_bonus, 0, ',', '.') }}</span>
                </div>
                <div class="breakdown-item">
                    <span class="breakdown-label">Lembur ({{ $gaji->lama_lembur }} jam)</span>
                    <span class="breakdown-value amount-primary">Rp {{ number_format($gaji->total_lembur, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="total-section">
            <div class="total-label">TOTAL PENDAPATAN BERSIH</div>
            <div class="total-amount">Rp {{ number_format($gaji->total_pendapatan, 0, ',', '.') }}</div>
        </div>

        <!-- Catatan -->
        <div class="section">
            <div class="section-title">Informasi & Catatan</div>
            <table class="info-table">
                <tr>
                    <th>Status Pembayaran</th>
                    <td>
                        @if($gaji->serahkan === 'sudah')
                            <span style="color: #10b981; font-weight: 600;">✓ SUDAH DISERAHKAN</span>
                        @else
                            <span style="color: #f59e0b; font-weight: 600;">● BELUM DISERAHKAN</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Metode Hitung</th>
                    <td>Gaji Pokok + Tunjangan + Bonus + Lembur</td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>Slip ini sah dan diterbitkan oleh sistem</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                <strong>Slip Gaji Resmi</strong> - Dokumen ini dicetak otomatis dari sistem.<br>
                Keabsahan dokumen dapat diverifikasi melalui departemen HRD.
            </p>
        </div>
    </div>
</body>
</html>