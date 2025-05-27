@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="w-[27rem] md:w-full xl:w-full">

        <div id="scheduleContainer">
            @php
                $selectedDate = request()->query('tanggal', date('Y-m-d'));
                $jadwalUntukTanggal = $jadwals[$selectedDate] ?? collect();
            @endphp

            <div class="flex gap-4 items-center mb-6">
                <!-- Date Picker -->
                <div>
                    <input type="date" id="datePicker"
                        class="form-input px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        value="{{ $selectedDate }}">
                </div>

                <div>
                    @php
                        $route =
                            Auth::user()->role === 'admin'
                                ? route('admin.pemesanan.create')
                                : route('pemesanan.create');
                    @endphp

                    <a href="{{ $route }}"
                        class="text-white bg-green-700 hover:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Pemesanan
                    </a>
                </div>
            </div>


            <div class="bg-white shadow-sm rounded-lg mb-6">
                <div class="p-4">
                    @php
                        \Carbon\Carbon::setLocale('id');
                    @endphp
                    <h5 class="text-center text-xl font-semibold text-black mb-4">
                        {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}
                    </h5>
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto text-center text-sm text-gray-700 border-collapse">
                            <thead class="bg-emerald-600 text-white">
                                <tr>
                                    <th class="px-4 py-2 border border-gray-300"><i class="fas fa-clock mr-2"></i>Jam</th>
                                    @for ($lapangan = 1; $lapangan <= 5; $lapangan++)
                                        <th class="px-4 py-2 border border-gray-300" colspan="2">
                                            <i class="fas fa-futbol mr-2"></i>Lapangan {{ $lapangan }}
                                        </th>
                                    @endfor
                                </tr>
                                <tr class="bg-teal-500 text-white">
                                    <th class="px-4 py-2 border border-gray-300">Waktu</th>
                                    @for ($lapangan = 1; $lapangan <= 5; $lapangan++)
                                        <th class="px-4 py-2 border border-gray-300">Nama Tim</th>
                                        <th class="px-4 py-2 border border-gray-300">DP</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $jamList = [
                                        '07:00',
                                        '08:00',
                                        '09:00',
                                        '10:00',
                                        '11:00',
                                        '12:00',
                                        '13:00',
                                        '14:00',
                                        '15:00',
                                        '16:00',
                                        '17:00',
                                        '18:00',
                                        '19:00',
                                        '20:00',
                                        '21:00',
                                        '22:00',
                                        '23:00',
                                    ];
                                @endphp

                                @if ($jadwalUntukTanggal->isEmpty())
                                    <tr>
                                        <td colspan="11" class="px-4 py-2 border border-gray-300 italic text-gray-500">
                                            Data tidak ditemukan</td>
                                    </tr>
                                @else
                                    @foreach ($jamList as $jam)
                                        <tr class="border-t border-b border-gray-300">
                                            <td class="px-4 py-2 border border-gray-300">{{ $jam }}</td>

                                            @for ($lapangan = 1; $lapangan <= 5; $lapangan++)
                                                @php
                                                    $booking = $jadwalUntukTanggal->first(function ($item) use (
                                                        $jam,
                                                        $lapangan,
                                                    ) {
                                                        return $item->jam == $jam && $item->lapangan == $lapangan;
                                                    });

                                                @endphp

                                                @if ($booking)
                                                    <td class="px-4 py-2 border border-gray-300">{{ $booking->nama_tim }}
                                                    </td>
                                                    <td class="px-4 py-2 border border-gray-300">
                                                        @if (!is_null($booking->dp))
                                                            {{ number_format($booking->dp, 0, ',', '.') }}
                                                        @endif
                                                    </td>
                                                @else
                                                    <td class="px-4 py-2 border border-gray-300"></td>
                                                    <td class="px-4 py-2 border border-gray-300"></td>
                                                @endif
                                            @endfor
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const datePicker = document.getElementById('datePicker');
        const scheduleContainer = document.getElementById('scheduleContainer');

        datePicker.addEventListener('change', () => {
            const selectedDate = datePicker.value;
            if (!selectedDate) return;

            // Kirim request GET dengan query tanggal ke route ini untuk reload data
            // Atau kamu bisa pakai ajax untuk reload bagian tabel saja, tapi ini cara paling sederhana:
            window.location.href = `?tanggal=${selectedDate}`;
        });
    </script>
@endsection
