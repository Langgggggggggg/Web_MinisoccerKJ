<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        /* Styling untuk PDF */
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 30px;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 12px;
            color: #666;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
        }
        
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .footer {
            margin-top: 30px;
            font-size: 10px;
            color: #666;
            text-align: center;
        }
        
        .summary {
            margin: 20px 0;
            padding: 15px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        
        .summary-title {
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .summary-value {
            font-size: 16px;
            font-weight: bold;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        .watermark {
            position: absolute;
            top: 50%;
            left: 30%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(200, 200, 200, 0.15);
            z-index: -1;
        }
    </style>
</head>
<body>
    <!-- Watermark (optional) -->
    <div class="watermark">LAPORAN KEUANGAN</div>
    
    <!-- Header -->
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Dicetak pada: {{ $tanggalCetak }}</p>
    </div>
    
    <!-- Summary -->
    <div class="summary">
        <div class="summary-title">Total Pendapatan:</div>
        <div class="summary-value">Rp {{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}</div>
        <p>Periode: {{ \Carbon\Carbon::parse($bulan)->format('F Y') }}</p>
        <p>
            Jenis Laporan: 
            @if($view_type == 'daily')
                Harian
            @elseif($view_type == 'weekly')
                Mingguan
            @else
                Bulanan
            @endif
        </p>
    </div>
    
    <!-- Table Data -->
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">No</th>
                <th style="width: 40%;">
                    @if($view_type == 'daily')
                        Tanggal
                    @elseif($view_type == 'weekly')
                        Periode Minggu
                    @else
                        Bulan
                    @endif
                </th>
                <th style="width: 20%;">Jumlah Transaksi</th>
                <th style="width: 30%;">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($groupedData as $index => $period)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $period['date'] }}</td>
                    <td>{{ $period['count'] }}</td>
                    <td>{{ number_format($period['total'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data untuk periode yang dipilih</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="font-weight: bold;">Total</td>
                <td style="font-weight: bold;">{{ $groupedData->sum('count') }}</td>
                <td style="font-weight: bold;">{{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
    
    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dihasilkan secara otomatis dan tidak memerlukan tanda tangan.</p>
        <p>&copy; {{ date('Y') }} Sistem Keuangan. Semua hak dilindungi.</p>
    </div>
</body>
</html>