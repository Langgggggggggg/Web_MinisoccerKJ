<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;


class KeuanganController extends Controller
{
    public function dataKeuangan(Request $request)
    {
        // Ambil parameter dari request
        $bulan = $request->get('bulan', date('Y-m')); // Format: YYYY-MM
        $view_type = $request->get('view_type', 'monthly'); // Default view: monthly, options: daily, weekly, monthly

        // Parse tanggal dari bulan yang dipilih
        $date = \Carbon\Carbon::createFromFormat('Y-m', $bulan);
        $start_date = clone $date->startOfMonth();
        $end_date = clone $date->endOfMonth();

        // Query base untuk data keuangan pada bulan tersebut
        $keuangan = Keuangan::where('bulan', $bulan)
            ->orderBy('tanggal', 'asc')
            ->get();

        // Untuk perhitungan total bulan ini
        $totalPendapatanBulanIni = $keuangan->sum('jumlah');

        // Data yang akan dikirim ke view sesuai dengan jenis tampilan
        $groupedData = [];

        switch ($view_type) {
            case 'daily':
                // Kelompokkan per hari
                $groupedData = $keuangan->groupBy(function ($item) {
                    return \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d');
                })->map(function ($items) {
                    return [
                        'date' => \Carbon\Carbon::parse($items->first()->tanggal)->format('d F Y'),
                        'count' => $items->count(),
                        'total' => $items->sum('jumlah')
                    ];
                });
                break;

            case 'weekly':
                // Kelompokkan per minggu
                $currentDate = clone $start_date;
                $weekData = [];

                while ($currentDate <= $end_date) {
                    $weekStart = clone $currentDate->startOfWeek();
                    $weekEnd = clone $currentDate->endOfWeek();

                    // Filter data untuk minggu ini
                    $weekItems = $keuangan->filter(function ($item) use ($weekStart, $weekEnd) {
                        $itemDate = \Carbon\Carbon::parse($item->tanggal);
                        return $itemDate >= $weekStart && $itemDate <= $weekEnd;
                    });

                    if ($weekItems->count() > 0) {
                        $weekData[$weekStart->format('W')] = [
                            'date' => $weekStart->format('d M') . ' - ' . $weekEnd->format('d M Y'),
                            'count' => $weekItems->count(),
                            'total' => $weekItems->sum('jumlah')
                        ];
                    }

                    $currentDate->addWeek();
                }

                $groupedData = collect($weekData);
                break;

            case 'monthly':
            default:
                // Kelompokkan per bulan (default)
                $groupedData = $keuangan->groupBy(function ($item) {
                    // Group by month name
                    return \Carbon\Carbon::parse($item->tanggal)->format('F');
                })->map(function ($items) {
                    return [
                        'date' => \Carbon\Carbon::parse($items->first()->tanggal)->format('F Y'),
                        'count' => $items->count(),
                        'total' => $items->sum('jumlah')
                    ];
                });
                break;
        }

        // Statistik tambahan untuk dashboard
        $hariIni = \Carbon\Carbon::now()->format('Y-m-d');
        $mingguIni = \Carbon\Carbon::now()->startOfWeek()->format('Y-m-d');

        $pendapatanHariIni = Keuangan::whereDate('tanggal', $hariIni)->sum('jumlah');
        $pendapatanMingguIni = Keuangan::where('tanggal', '>=', $mingguIni)->sum('jumlah');

        // Data untuk grafik (jika diperlukan)
        $chartData = $this->prepareChartData($keuangan, $view_type, $start_date, $end_date);

        return view('admin.keuangan', compact(
            'groupedData',
            'totalPendapatanBulanIni',
            'bulan',
            'view_type',
            'pendapatanHariIni',
            'pendapatanMingguIni',
            'chartData'
        ));
    }

    /**
     * Menyiapkan data untuk grafik berdasarkan tipe tampilan
     */
    private function prepareChartData($keuangan, $view_type, $start_date, $end_date)
    {
        $chartData = [];

        switch ($view_type) {
            case 'daily':
                // Siapkan data harian untuk grafik
                $currentDate = clone $start_date;
                while ($currentDate <= $end_date) {
                    $dateStr = $currentDate->format('Y-m-d');
                    $dayData = $keuangan->filter(function ($item) use ($dateStr) {
                        return $item->tanggal == $dateStr;
                    });

                    $chartData[] = [
                        'label' => $currentDate->format('d M'),
                        'value' => $dayData->sum('jumlah')
                    ];

                    $currentDate->addDay();
                }
                break;

            case 'weekly':
                // Siapkan data mingguan untuk grafik
                $currentDate = clone $start_date;
                while ($currentDate <= $end_date) {
                    $weekStart = clone $currentDate->startOfWeek();
                    $weekEnd = clone $currentDate->endOfWeek();

                    $weekData = $keuangan->filter(function ($item) use ($weekStart, $weekEnd) {
                        $itemDate = \Carbon\Carbon::parse($item->tanggal);
                        return $itemDate >= $weekStart && $itemDate <= $weekEnd;
                    });

                    $chartData[] = [
                        'label' => 'W' . $weekStart->format('W'),
                        'value' => $weekData->sum('jumlah')
                    ];

                    $currentDate->addWeek();

                    // Hindari duplikasi minggu
                    if ($currentDate->format('W') == $weekStart->format('W')) {
                        $currentDate->addWeek();
                    }
                }
                break;

            case 'monthly':
            default:
                // Untuk tampilan bulanan, kita ambil data per hari dalam bulan tersebut
                $chartData = $keuangan->groupBy(function ($item) {
                    return \Carbon\Carbon::parse($item->tanggal)->format('d');
                })->map(function ($items, $day) {
                    return [
                        'label' => 'Tgl ' . $day,
                        'value' => $items->sum('jumlah')
                    ];
                })->values()->toArray();
                break;
        }

        return $chartData;
    }

    public function exportKeuanganPDF(Request $request)
    {
        // Ambil parameter dari request
        $bulan = $request->get('bulan', date('Y-m'));
        $view_type = $request->get('view_type', 'monthly');

        // Parse tanggal dari bulan yang dipilih
        $date = \Carbon\Carbon::createFromFormat('Y-m', $bulan);
        $start_date = clone $date->startOfMonth();
        $end_date = clone $date->endOfMonth();

        // Query data keuangan
        $keuangan = Keuangan::where('bulan', $bulan)
            ->orderBy('tanggal', 'asc')
            ->get();

        // Untuk perhitungan total bulan ini
        $totalPendapatanBulanIni = $keuangan->sum('jumlah');

        // Data yang akan dikirim ke view sesuai dengan jenis tampilan
        $groupedData = [];
        $title = '';

        switch ($view_type) {
            case 'daily':
                // Kelompokkan per hari
                $groupedData = $keuangan->groupBy(function ($item) {
                    return \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d');
                })->map(function ($items) {
                    return [
                        'date' => \Carbon\Carbon::parse($items->first()->tanggal)->format('d F Y'),
                        'count' => $items->count(),
                        'total' => $items->sum('jumlah')
                    ];
                });
                $title = 'Laporan Keuangan Harian - ' . $date->format('F Y');
                break;

            case 'weekly':
                // Kelompokkan per minggu
                $currentDate = clone $start_date;
                $weekData = [];

                while ($currentDate <= $end_date) {
                    $weekStart = clone $currentDate->startOfWeek();
                    $weekEnd = clone $currentDate->endOfWeek();

                    // Filter data untuk minggu ini
                    $weekItems = $keuangan->filter(function ($item) use ($weekStart, $weekEnd) {
                        $itemDate = \Carbon\Carbon::parse($item->tanggal);
                        return $itemDate >= $weekStart && $itemDate <= $weekEnd;
                    });

                    if ($weekItems->count() > 0) {
                        $weekData[$weekStart->format('W')] = [
                            'date' => $weekStart->format('d M') . ' - ' . $weekEnd->format('d M Y'),
                            'count' => $weekItems->count(),
                            'total' => $weekItems->sum('jumlah')
                        ];
                    }

                    $currentDate->addWeek();
                }

                $groupedData = collect($weekData);
                $title = 'Laporan Keuangan Mingguan - ' . $date->format('F Y');
                break;

            case 'monthly':
            default:
                // Kelompokkan per bulan (default)
                $groupedData = $keuangan->groupBy(function ($item) {
                    // Group by month name
                    return \Carbon\Carbon::parse($item->tanggal)->format('F');
                })->map(function ($items) {
                    return [
                        'date' => \Carbon\Carbon::parse($items->first()->tanggal)->format('F Y'),
                        'count' => $items->count(),
                        'total' => $items->sum('jumlah')
                    ];
                });
                $title = 'Laporan Keuangan Bulanan - ' . $date->format('F Y');
                break;
        }

        // Buat tanggal untuk footer laporan
        $tanggalCetak = now()->format('d F Y H:i:s');

        // Siapkan data untuk view PDF
        $data = [
            'title' => $title,
            'tanggalCetak' => $tanggalCetak,
            'bulan' => $bulan,
            'view_type' => $view_type,
            'groupedData' => $groupedData,
            'totalPendapatanBulanIni' => $totalPendapatanBulanIni,
        ];

        // Buat nama file PDF
        $fileName = strtolower(str_replace(' ', '_', $title)) . '.pdf';

        // Generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.keuangan_pdf', $data);

        // Setting PDF (opsional)
        $pdf->setPaper('a4', 'portrait');

        // Download PDF
        return $pdf->download($fileName);
    }
}
