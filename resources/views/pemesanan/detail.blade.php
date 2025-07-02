@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="w-[18rem] md:w-full xl:w-full">
        <div class="lg:w-[75rem] max-w-full overflow-x-auto bg-white rounded-lg shadow-md">
            <div class="flex flex-col md:flex-row justify-between items-center border-b border-gray-200 p-2 gap-2">
                <div class="flex space-x-2">
                    <button id="tabBelumLunas"
                        class="tab-button px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-t-md hover:bg-gray-200"
                        data-status="belumLunas">
                        Belum Lunas
                    </button>
                    <button id="tabLunas"
                        class="tab-button px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-t-md hover:bg-gray-200"
                        data-status="lunas">
                        Riwayat Pemesanan
                    </button>
                </div>

                <input type="text" id="searchInput" placeholder="Cari.."
                    class="p-2 border rounded-md text-sm w-full md:w-1/3 lg:w-1/4 xl:w-1/5 2xl:w-1/6 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">   
            </div>

            <table class="table-auto w-full text-center text-sm text-gray-700">
                <thead class="bg-gray-50">
                    <tr class="text-gray-500">
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
                        <th class="px-4 py-2 border-b" id="aksiHeader" style="display: none;">Aksi</th>

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
                                        {{ $pesan->lapangan }}</td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">
                                        Rp{{ number_format($pesan->dp, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">
                                        Rp{{ number_format($pesan->harga, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">
                                        Rp{{ number_format($pesan->sisa_bayar, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">
                                        <span
                                            class="inline-block text-xs md:text-sm font-medium {{ $pesan->status == 'lunas' ? 'bg-green-500' : ($pesan->status == 'belum lunas' ? 'bg-yellow-500' : 'bg-red-500') }} text-white px-3 py-1 rounded-md shadow whitespace-nowrap">
                                            {{ ucfirst($pesan->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 border-b aksiColumn" id="aksiColumn" style="display: none;">
                                        <div class="flex flex-col md:flex-row space-x-2 space-y-2 md:space-y-0">
                                            @if ($pesan->status == 'belum lunas' && $loop->first)
                                                <a href="{{ route('pemesanan.edit', $pesan->kode_pemesanan) }}"
                                                    class="inline-block bg-green-700 hover:bg-green-600 text-white text-xs md:text-sm font-medium px-3 py-1 rounded-md shadow transition duration-200 text-center whitespace-nowrap">
                                                    Ubah Jadwal
                                                </a>
                                            @endif
                                            @if ($pesan->status == 'belum lunas')
                                                <a href="{{ route('refunds.create', $pesan->id) }}"
                                                    class="inline-block bg-red-700 hover:bg-red-600 text-white text-xs md:text-sm font-medium px-3 py-1 rounded-md shadow transition duration-200 text-center whitespace-nowrap">
                                                    Ajukan Refund
                                                </a>
                                            @endif
                                        </div>
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

    <script>
        // Pesan dari session flash (redirect backend)
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: @json(session('success'))
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: @json(session('error'))
            });
        @endif

        // Pesan dari query string (redirect JS)
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('success') === 'member') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Pemesanan member berhasil!'
            });
            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('success');
                window.history.replaceState({}, document.title, url.pathname + url.search);
            }
        } else if (urlParams.get('success') === 'reguler' || urlParams.get('success') === '1') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Pemesanan berhasil!'
            });
            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('success');
                window.history.replaceState({}, document.title, url.pathname + url.search);
            }
        }
        if (urlParams.get('error') === '1') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Pemesanan gagal!'
            });
            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('error');
                window.history.replaceState({}, document.title, url.pathname + url.search);
            }
        }
    </script>
@endsection
