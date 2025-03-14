@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="w-[27rem] md:w-full xl:w-full">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            <div>
                <!-- Dropdown Pilih Bulan -->
                <label for="monthSelector" class="block text-sm font-medium text-gray-700 mb-2">Pilih Bulan:</label>
                <select id="monthSelector" class="form-select block w-80 md:w-full p-2 border border-gray-300 rounded-md">
                    @foreach ($jadwals->groupBy(function ($item) {
            return date('Y-m', strtotime($item->tanggal)); // Format YYYY-MM
        }) as $bulan => $jadwal)
                        @php
                            $bulanIndonesia = [
                                'January' => 'Januari',
                                'February' => 'Februari',
                                'March' => 'Maret',
                                'April' => 'April',
                                'May' => 'Mei',
                                'June' => 'Juni',
                                'July' => 'Juli',
                                'August' => 'Agustus',
                                'September' => 'September',
                                'October' => 'Oktober',
                                'November' => 'November',
                                'December' => 'Desember',
                            ];
                            $bulanFormatted = date('F Y', strtotime($bulan . '-01'));
                            $bulanTranslated = str_replace(
                                array_keys($bulanIndonesia),
                                array_values($bulanIndonesia),
                                $bulanFormatted,
                            );
                        @endphp
                        <option value="{{ $bulan }}">{{ $bulanTranslated }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <!-- Dropdown Pilih Tanggal -->
                <label for="dateSelector" class="block text-sm font-medium text-gray-700 mb-2">Pilih Tanggal:</label>
                <select id="dateSelector" class="form-select block w-80 md:w-full xl:w-full p-2 border border-gray-300 rounded-md">
                    @foreach ($jadwals->groupBy('tanggal') as $tanggal => $jadwal)
                        <option value="table-{{ $tanggal }}" data-month="{{ date('Y-m', strtotime($tanggal)) }}">
                            {{ date('d', strtotime($tanggal)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button id="showScheduleButton"
                    class="btn btn-primary mt-4 py-2 px-4 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Tampilkan Jadwal
                </button>
                <a href="{{ route('pemesanan.create') }}"
                    class="btn btn-success mt-4 py-2 px-4 bg-green-500 text-white rounded-md hover:bg-green-600">
                    Tambah Pesanan
                </a>
            </div>
        </div>

        @foreach ($jadwals->groupBy('tanggal') as $tanggal => $jadwal)
            <div id="table-{{ $tanggal }}" class="schedule-table hidden">
                <div class="bg-white shadow-sm rounded-lg mb-6">
                    <div class="p-4">
                        <h5 class="text-center text-xl font-semibold text-black mb-4">
                            {{ date('l, d F Y', strtotime($tanggal)) }}</h5>
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto text-center text-sm text-gray-700 border-collapse">
                                <thead class="bg-emerald-600 text-white">
                                    <tr>
                                        <th class="px-4 py-2 border border-gray-300">
                                            <i class="fas fa-clock mr-2"></i>Jam
                                        </th>
                                        <th class="px-4 py-2 border border-gray-300" colspan="2">
                                            <i class="fas fa-futbol mr-2"></i>Lapangan 1
                                        </th>
                                        <th class="px-4 py-2 border border-gray-300" colspan="2">
                                            <i class="fas fa-futbol mr-2"></i>Lapangan 2
                                        </th>
                                        <th class="px-4 py-2 border border-gray-300" colspan="2">
                                            <i class="fas fa-futbol mr-2"></i> Lapangan 3
                                        </th>
                                        <th class="px-4 py-2 border border-gray-300" colspan="2">
                                            <i class="fas fa-futbol mr-2"></i> Lapangan 4
                                        </th>
                                        <th class="px-4 py-2 border border-gray-300" colspan="2">
                                            <i class="fas fa-futbol mr-2"></i> Lapangan 5
                                        </th>
                                    </tr>
                                    <tr class="bg-teal-500 text-white">
                                        <th class="px-4 py-2 border border-gray-300">Waktu</th>
                                        <th class="px-4 py-2 border border-gray-300">Nama Tim</th>
                                        <th class="px-4 py-2 border border-gray-300">DP</th>
                                        <th class="px-4 py-2 border border-gray-300">Nama Tim</th>
                                        <th class="px-4 py-2 border border-gray-300">DP</th>
                                        <th class="px-4 py-2 border border-gray-300">Nama Tim</th>
                                        <th class="px-4 py-2 border border-gray-300">DP</th>
                                        <th class="px-4 py-2 border border-gray-300">Nama Tim</th>
                                        <th class="px-4 py-2 border border-gray-300">DP</th>
                                        <th class="px-4 py-2 border border-gray-300">Nama Tim</th>
                                        <th class="px-4 py-2 border border-gray-300">DP</th>
                                </thead>
                                <tbody>
                                    @foreach (['07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'] as $jam)
                                        <tr class="border-t border-b border-gray-300">
                                            <td class="px-4 py-2 border border-gray-300">{{ $jam }}</td>
                                            @for ($lapangan = 1; $lapangan <= 5; $lapangan++)
                                                @php
                                                    $booking = $jadwal
                                                        ->where('jam', $jam . ':00')
                                                        ->where('lapangan', $lapangan)
                                                        ->first();
                                                @endphp
                                                @if ($booking)
                                                    <td class="px-4 py-2 border border-gray-300">
                                                        {{ $booking->pemesanan?->nama_tim }}</td>
                                                    <td class="px-4 py-2 border border-gray-300">
                                                        {{ $booking->pemesanan?->dp }}</td>
                                                @else
                                                    <td class="px-4 py-2 border border-gray-300"></td>
                                                    <td class="px-4 py-2 border border-gray-300"></td>
                                                @endif
                                            @endfor
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
