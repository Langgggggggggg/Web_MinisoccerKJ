@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="w-[27rem] md:w-full xl:w-full">
        @if (session('success'))
            <div class="alert alert-success bg-green-500 text-white p-3 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif
        <div class="max-w-full overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="table-auto w-full text-center text-sm text-gray-700">
                <thead class="bg-emerald-600">
                    <tr class="text-white">
                        <th class="px-4 py-2 border-b">Kode Pemesanan</th>
                        <th class="px-4 py-2 border-b">Nama Tim</th>
                        <th class="px-4 py-2 border-b">Tanggal</th>
                        <th class="px-4 py-2 border-b"> Jam Mulai</th>
                        <th class="px-4 py-2 border-b">Jam Selesai</th>
                        <th class="px-4 py-2 border-b">Lapangan</th>
                        <th class="px-4 py-2 border-b">DP</th>
                        <th class="px-4 py-2 border-b">Harga Lapang</th>
                        <th class="px-4 py-2 border-b">Sisa Bayar</th>
                        <th class="px-4 py-2 border-b">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groupedPemesanan as $kodePemesanan => $pemesans)
                        @foreach ($pemesans as $pesan)
                            <tr class="hover:bg-gray-100">
                                @if ($loop->first)
                                    <!-- Hanya tampilkan data kode pemesanan sekali -->
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">{{ $pesan->kode_pemesanan }}</td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">{{ $pesan->nama_tim }}</td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">{{ $pesan->tanggal }}</td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">{{ $pesan->jam_mulai }}</td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">{{ $pesan->jam_selesai }}</td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">{{ $pesan->jadwal->lapangan }}</td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">Rp{{ number_format($pesan->dp, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">Rp{{ number_format($pesan->harga, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 border-b" rowspan="{{ count($pemesans) }}">Rp{{ number_format($pesan->sisa_bayar, 0, ',', '.') }}</td>
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
@endsection
