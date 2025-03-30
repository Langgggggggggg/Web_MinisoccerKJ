@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="w-[27rem] md:w-full xl:w-full">
        <div class="max-w-full overflow-x-auto bg-white rounded-lg shadow-md">
            <div class="flex flex-col md:flex-row justify-between items-center border-b border-gray-200 p-2 gap-2">
                <div class="flex space-x-2">
                    <button id="tabBelumLunas"
                        class="tab-button px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-t-md hover:bg-gray-200"
                        onclick="showTab('belumLunas')">
                        Belum Lunas
                    </button>
                    <button id="tabLunas"
                        class="tab-button px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-t-md hover:bg-gray-200"
                        onclick="showTab('lunas')">
                        Riwayat Pemesanan
                    </button>
                </div>
            
                <input type="text" id="searchInput" placeholder="Cari.."
                    class="p-2 border rounded-md text-sm w-full md:w-1/3 lg:w-1/4 xl:w-1/5 2xl:w-1/6 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            
            <table class="table-auto w-full text-center text-sm text-gray-700">
                <thead class="bg-emerald-600">
                    <tr class="text-white">
                        <th class="px-4 py-2 border-b">Kode Pemesanan</th>
                        <th class="px-4 py-2 border-b">Nama Tim</th>
                        <th class="px-4 py-2 border-b">Tanggal</th>
                        <th class="px-4 py-2 border-b">Jam Mulai</th>
                        <th class="px-4 py-2 border-b">Jam Selesai</th>
                        <th class="px-4 py-2 border-b">Lapangan</th>
                        <th class="px-4 py-2 border-b">DP</th>
                        <th class="px-4 py-2 border-b">Harga Lapang</th>
                        <th class="px-4 py-2 border-b">Sisa Bayar</th>
                        <th class="px-4 py-2 border-b">Status</th>
                    </tr>
                </thead>
                <tbody id="tableContent" class="hidden">
                    @forelse($groupedPemesanan as $kodePemesanan => $pemesans)
                        @foreach ($pemesans as $pesan)
                            <tr class="hover:bg-gray-100 {{ $pesan->status == 'lunas' ? 'lunas' : 'belumLunas' }}">
                                @if ($loop->first)
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">
                                        {{ $pesan->kode_pemesanan }}</td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">{{ $pesan->nama_tim }}
                                    </td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">{{ $pesan->tanggal }}
                                    </td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">{{ $pesan->jam_mulai }}
                                    </td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">
                                        {{ $pesan->jam_selesai }}</td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">
                                        {{ $pesan->jadwal->lapangan }}</td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">
                                        Rp{{ number_format($pesan->dp, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">
                                        Rp{{ number_format($pesan->harga, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">
                                        Rp{{ number_format($pesan->sisa_bayar, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">
                                        <span
                                            class="badge {{ $pesan->status == 'lunas' ? 'bg-green-500' : 'bg-yellow-500' }} text-white py-1 px-2 rounded-md">
                                            {{ ucfirst($pesan->status) }}
                                        </span>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="9" class="text-center p-4">
                                <div class="alert alert-warning bg-yellow-200 text-yellow-800 p-3 rounded-md">
                                    Tidak ada pesanan yang tersedia.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
     <!-- Sweet Alert CDN -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

     @if (session('success'))
         <script>
             Swal.fire({
                 icon: 'success',
                 title: 'Berhasil!',
                 text: "{{ session('success') }}"
             });
         </script>
     @endif
 
     @if (session('error'))
         <script>
             Swal.fire({
                 icon: 'error',
                 title: 'Gagal!',
                 text: "{{ session('error') }}"
             });
         </script>
     @endif
    <script>
        function showTab(status) {
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('bg-emerald-500', 'text-white');
                button.classList.add('bg-gray-100', 'text-gray-600');
            });

            document.getElementById('tab' + status.charAt(0).toUpperCase() + status.slice(1)).classList.add(
                'bg-emerald-500', 'text-white');
            document.getElementById('tab' + status.charAt(0).toUpperCase() + status.slice(1)).classList.remove(
                'bg-gray-100', 'text-gray-600');

            document.querySelectorAll('tbody tr').forEach(row => {
                row.style.display = 'none';
            });
            document.querySelectorAll('.' + status).forEach(row => {
                row.style.display = '';
            });
        }
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('tableContent').classList.remove(
                'hidden'); // Tampilkan tabel setelah JS dijalankan
            showTab('belumLunas');
        });
        document.getElementById("searchInput").addEventListener("input", function() {
            let searchValue = this.value.toLowerCase().trim();
            let allRows = document.querySelectorAll("tbody tr");

            // Menentukan tab yang sedang aktif
            let activeTab = document.querySelector(".tab.active");
            let activeTabId = activeTab ? activeTab.id : "tabBelumLunas";
            let activeStatus = activeTabId === "tabLunas" ? "lunas" : "belumLunas";

            let foundInBelumLunas = false;
            let foundInLunas = false;

            allRows.forEach(row => {
                let kodePemesanan = row.cells[0]?.innerText.toLowerCase();
                let namaTim = row.cells[1]?.innerText.toLowerCase();
                let status = row.classList.contains("lunas") ? "lunas" : "belumLunas";

                if (kodePemesanan.includes(searchValue) || namaTim.includes(searchValue)) {
                    if (status === "lunas") {
                        foundInLunas = true;
                    } else {
                        foundInBelumLunas = true;
                    }
                }
            });

            // Jika input kosong, tampilkan tab "Belum Lunas" dan hanya data yang sesuai
            if (searchValue === "") {
                showTab("belumLunas"); // Pindah ke tab "Belum Lunas"
                allRows.forEach(row => {
                    let status = row.classList.contains("lunas") ? "lunas" : "belumLunas";
                    row.style.display = (status === "belumLunas") ? "" : "none";
                });
                return;
            }

            // Menentukan tab berdasarkan hasil pencarian
            if (foundInLunas) {
                showTab("lunas");
            } else if (foundInBelumLunas) {
                showTab("belumLunas");
            }

            allRows.forEach(row => {
                let kodePemesanan = row.cells[0]?.innerText.toLowerCase();
                let namaTim = row.cells[1]?.innerText.toLowerCase();
                let status = row.classList.contains("lunas") ? "lunas" : "belumLunas";

                if ((kodePemesanan.includes(searchValue) || namaTim.includes(searchValue)) &&
                    ((foundInLunas && status === "lunas") || (foundInBelumLunas && status === "belumLunas"))
                    ) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    </script>
@endsection
