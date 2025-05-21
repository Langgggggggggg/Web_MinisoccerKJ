@extends('layouts.app')
@section('header')
    @include('layouts.header')
@endsection
@section('content')
    <div class="container mx-auto px-4">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Daily Stats -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-green-500 px-6 py-3">
                    <h3 class="text-white font-medium">Pendapatan Hari Ini</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="text-2xl font-bold text-gray-800">
                            Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">{{ now()->format('d F Y') }}</p>
                </div>
            </div>
            <!-- Weekly Stats -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-blue-500 px-6 py-3">
                    <h3 class="text-white font-medium">Pendapatan Minggu Ini</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="text-2xl font-bold text-gray-800">
                            Rp {{ number_format($pendapatanMingguIni, 0, ',', '.') }}
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ \Carbon\Carbon::now()->startOfWeek()->format('d M') }} - 
                        {{ \Carbon\Carbon::now()->endOfWeek()->format('d M Y') }}
                    </p>
                </div>
            </div>
            <!-- Monthly Stats -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-purple-500 px-6 py-3">
                    <h3 class="text-white font-medium">Pendapatan Bulan Ini</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="text-2xl font-bold text-gray-800">
                            Rp {{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ \Carbon\Carbon::parse($bulan)->format('F Y') }}
                    </p>
                </div>
            </div>
        </div>
        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-800">Filter Data</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label for="bulan" class="block text-sm font-medium text-gray-700 mb-1">Bulan:</label>
                        <input type="month" id="bulan" name="bulan" 
                               class="border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               value="{{ $bulan }}">
                    </div>
                    <div>
                        <label for="view_type" class="block text-sm font-medium text-gray-700 mb-1">Tampilkan Sebagai:</label>
                        <select id="view_type" name="view_type" 
                                class="border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="daily" {{ $view_type == 'daily' ? 'selected' : '' }}>Harian</option>
                            <option value="weekly" {{ $view_type == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                            <option value="monthly" {{ $view_type == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button onclick="filterData()" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors w-full">
                            Terapkan Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Chart Section -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-800">
                    Grafik Pendapatan 
                    @if($view_type == 'daily')
                        Harian
                    @elseif($view_type == 'weekly')
                        Mingguan
                    @else
                        Bulanan
                    @endif
                </h2>
            </div>
            <div class="p-6">
                <div class="w-full h-64" id="keuangan-chart"></div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">
                    Data Keuangan 
                    @if($view_type == 'daily')
                        Per Hari
                    @elseif($view_type == 'weekly')
                        Per Minggu
                    @else
                        Per Bulan
                    @endif
                </h2>
                <a href="{{ route('admin.keuangan.export', ['bulan' => $bulan, 'view_type' => $view_type]) }}" 
                   class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded inline-flex items-center space-x-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Export PDF</span>
                </a>
            </div>
            <!-- Table Section -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h2 class="text-lg font-semibold text-gray-800">
                        Data Keuangan 
                        @if($view_type == 'daily')
                            Per Hari
                        @elseif($view_type == 'weekly')
                            Per Minggu
                        @else
                            Per Bulan
                        @endif
                    </h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    @if($view_type == 'daily')
                                        Tanggal
                                    @elseif($view_type == 'weekly')
                                        Periode Minggu
                                    @else
                                        Bulan
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Transaksi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tim</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($groupedData as $period)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $period['date'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $period['count'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        Rp {{ number_format($period['total'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $period['tim_info'] ?? 'Tidak ada tim' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                        Tidak ada data untuk periode yang dipilih
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">Total Pendapatan</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                                    {{ $groupedData->sum('count') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    Rp {{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript for filtering and charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
    <script>
        function filterData() {
            const bulan = document.getElementById('bulan').value;
            const viewType = document.getElementById('view_type').value;
            window.location.href = `{{ route('admin.keuangan') }}?bulan=${bulan}&view_type=${viewType}`;
        }
        // Chart rendering
        document.addEventListener('DOMContentLoaded', function() {
            const chartData = @json($chartData);
            
            const options = {
                series: [{
                    name: 'Pendapatan',
                    data: chartData.map(item => item.value)
                }],
                chart: {
                    type: 'bar',
                    height: 250,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: false,
                        columnWidth: '70%',
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: chartData.map(item => item.label),
                },
                colors: ['#4F46E5'],
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "Rp " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                }
            };
            const chart = new ApexCharts(document.querySelector("#keuangan-chart"), options);
            chart.render();
        });
    </script>
@endsection