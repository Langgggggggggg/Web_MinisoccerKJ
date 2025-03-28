<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Penukaran Poin</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f3f4f6; }
        .container { max-width: 600px; margin: 20px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border: 1px solid #d1d5db; }
        .header { display: flex; justify-content: space-between; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { font-size: 24px; font-weight: bold; color: #1f2937; }
        .header p { font-size: 14px; color: #6b7280; }
        .info { margin-bottom: 20px; }
        .info h2 { font-size: 18px; font-weight: bold; color: #374151; margin-bottom: 10px; }
        .info p { color: #1f2937; }
        .stats { background-color: #f3f4f6; padding: 10px; border-radius: 6px; }
        .stats p { color: #1f2937; }
        .footer { border-top: 1px solid #e5e7eb; padding-top: 10px; text-align: center; font-size: 12px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div>
                <h1>INVOICE</h1>
                <p>Penukaran Poin</p>
            </div>
            <div>
                <p>Tanggal: {{ now()->format('d M Y') }}</p>
                <p>Kode Voucher: <strong>{{ $reward->kode_voucher ?? '-' }}</strong></p>
            </div>
        </div>

        <!-- Informasi Tim -->
        <div class="info">
            <h2>Informasi Tim</h2>
            <p><strong>Nama Tim:</strong> {{ $reward->nama_tim }}</p>
            <p><strong>Point Ditukarkan:</strong> {{ $reward->point }}</p>
            <p><strong>Nominal Cashback:</strong> Rp{{ number_format($reward->idr, 0, ',', '.') }}</p>
        </div>

        <!-- Statistik Bermain -->
        <div class="info">
            <h2>Statistik Bermain</h2>
            <div class="stats">
                <p><strong>Lapangan 1-3:</strong> {{ $totalBermain['lapangan_1_3'] }} kali</p>
                <p><strong>Lapangan 4-5:</strong> {{ $totalBermain['lapangan_4_5'] }} kali</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah bermain di <strong>Mini Soccer Keramat Jaya</strong></p>
            <p>Silakan tukarkan poin kembali di periode selanjutnya.</p>
        </div>
    </div>
</body>
</html>