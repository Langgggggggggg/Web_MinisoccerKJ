@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-4">
                <!-- Dropdown Pilih Bulan -->
                <label for="monthSelector" class="form-label">Pilih Bulan:</label>
                <select id="monthSelector" class="form-select">
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
            <div class="col-md-4">
                <!-- Dropdown Pilih Tanggal -->
                <label for="dateSelector" class="form-label">Pilih Tanggal:</label>
                <select id="dateSelector" class="form-select">
                    @foreach ($jadwals->groupBy('tanggal') as $tanggal => $jadwal)
                        <option value="table-{{ $tanggal }}" data-month="{{ date('Y-m', strtotime($tanggal)) }}">
                            {{ date('d', strtotime($tanggal)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button id="showScheduleButton" class="btn btn-primary mt-4">Tampilkan Jadwal</button>
                <a href="{{ route('pemesanan.create') }}" class="btn btn-success mt-4 ms-2">Tambah Pesanan</a>
            </div>
            
            
        </div>

        @foreach ($jadwals->groupBy('tanggal') as $tanggal => $jadwal)
            <div id="table-{{ $tanggal }}" class="schedule-table" style="display: none;">
                <div class="card shadow-sm rounded-3">
                    <div class="card-body">
                        <h5 class="text-center text-black mb-3">{{ date('l, d F Y', strtotime($tanggal)) }}</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle bg-white">
                                <thead>
                                    <tr class="bg-primary text-white">
                                        <th>Jam</th>
                                        <th colspan="2">Lapangan 1</th>
                                        <th colspan="2">Lapangan 2</th>
                                        <th colspan="2">Lapangan 3</th>
                                        <th colspan="2">Lapangan 4</th>
                                        <th colspan="2">Lapangan 5</th>
                                    </tr>
                                    <tr class="bg-primary text-white">
                                        <th>Waktu</th>
                                        <th>Nama Tim</th>
                                        <th>DP</th>
                                        <th>Nama Tim</th>
                                        <th>DP</th>
                                        <th>Nama Tim</th>
                                        <th>DP</th>
                                        <th>Nama Tim</th>
                                        <th>DP</th>
                                        <th>Nama Tim</th>
                                        <th>DP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (['07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'] as $jam)
                                        <tr>
                                            <td>{{ $jam }}</td>
                                            @for ($lapangan = 1; $lapangan <= 5; $lapangan++)
                                                @php
                                                    $booking = $jadwal
                                                        ->where('jam', $jam . ':00')
                                                        ->where('lapangan', $lapangan)
                                                        ->first();
                                                @endphp
                                                @if ($booking)
                                                    <td>{{ $booking->pemesanan?->nama_tim }}</td>
                                                    <td>{{ $booking->pemesanan?->dp }}</td>
                                                @else
                                                    <td></td>
                                                    <td></td>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let dateSelector = document.getElementById("dateSelector");
            let monthSelector = document.getElementById("monthSelector");
            let showScheduleButton = document.getElementById("showScheduleButton");
            let tables = document.querySelectorAll(".schedule-table");

            // Array konversi bulan & hari ke bahasa Indonesia
            const bulanIndonesia = {
                "January": "Januari",
                "February": "Februari",
                "March": "Maret",
                "April": "April",
                "May": "Mei",
                "June": "Juni",
                "July": "Juli",
                "August": "Agustus",
                "September": "September",
                "October": "Oktober",
                "November": "November",
                "December": "Desember"
            };

            const hariIndonesia = {
                "Sunday": "Minggu",
                "Monday": "Senin",
                "Tuesday": "Selasa",
                "Wednesday": "Rabu",
                "Thursday": "Kamis",
                "Friday": "Jumat",
                "Saturday": "Sabtu"
            };

            // Fungsi untuk menerjemahkan tanggal pada semua elemen dengan kelas schedule-table
            function translateDates() {
                document.querySelectorAll(".schedule-table h5").forEach(el => {
                    let text = el.innerText;
                    Object.keys(hariIndonesia).forEach(hari => {
                        text = text.replace(hari, hariIndonesia[hari]);
                    });
                    Object.keys(bulanIndonesia).forEach(bulan => {
                        text = text.replace(bulan, bulanIndonesia[bulan]);
                    });
                    el.innerText = text;
                });
            }

            function showSelectedTable() {
                let selectedId = dateSelector.value;

                tables.forEach(table => {
                    table.style.display = (table.id === selectedId) ? "block" : "none";
                });
            }

            function filterDatesByMonth() {
                let selectedMonth = monthSelector.value;
                let options = dateSelector.options;

                for (let i = 0; i < options.length; i++) {
                    let option = options[i];
                    let optionMonth = option.getAttribute("data-month");

                    if (selectedMonth === "" || optionMonth === selectedMonth) {
                        option.style.display = "block";
                    } else {
                        option.style.display = "none";
                    }
                }

                for (let i = 0; i < options.length; i++) {
                    if (options[i].style.display === "block") {
                        dateSelector.value = options[i].value;
                        break;
                    }
                }

                showSelectedTable();
            }

            // Event Listener
            monthSelector.addEventListener("change", filterDatesByMonth);
            showScheduleButton.addEventListener("click", showSelectedTable);

            // **Panggil fungsi saat halaman pertama kali dimuat**
            filterDatesByMonth();
            translateDates();
        });
    </script>
@endsection