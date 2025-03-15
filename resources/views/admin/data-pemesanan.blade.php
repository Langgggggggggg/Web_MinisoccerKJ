@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="w-[27rem] md:w-full xl:w-full">

        <div class="flex gap-4 justify-between">
            <!-- Search Bar -->
            <!-- Form Pencarian -->
            <form method="GET" action="{{ route('admin.data-pemesanan') }}" class="flex flex-wrap gap-4 mb-3">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari Nama Tim atau Kode Pemesanan" class="px-4 py-2 border rounded-md w-full sm:w-72 h-auto">
                <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-md w-full sm:w-auto h-auto">
                    <i class="fas fa-search mr-2"></i> Cari
                </button>
            </form>

            <!-- Filter Data -->
            <form method="GET" action="{{ route('admin.data-pemesanan') }}" class="flex flex-wrap gap-4 mb-3">
                <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                    class="px-4 py-2 border rounded-md w-full sm:w-auto">
                <select name="status" class="px-4 py-2 border rounded-md w-full sm:w-auto">
                    <option value="">Pilih Status</option>
                    <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="belum lunas" {{ request('status') == 'belum lunas' ? 'selected' : '' }}>Belum Lunas
                    </option>
                </select>
                <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-md w-full sm:w-auto">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
                {{-- <a href="{{ route('admin.data-pemesanan') }}"
                class="px-4 py-2 bg-gray-500 text-white rounded-md w-full sm:w-auto">
                <i class="fas fa-sync-alt mr-2"></i> Reset
            </a> --}}
            </form>
        </div>
        <!-- Tabel Data Pemesanan -->
        <div class="max-w-full overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="table-auto w-full text-center text-sm text-gray-700">
                <thead class="bg-emerald-600 text-white">
                    <tr>
                        <th class="px-4 py-2 border-b">Kode Pemesanan</th>
                        <th class="px-4 py-2 border-b">Nama Tim</th>
                        <th class="px-4 py-2 border-b">Tanggal</th>
                        <th class="px-4 py-2 border-b">Jam Mulai</th>
                        <th class="px-4 py-2 border-b">Jam Selesai</th>
                        <th class="px-4 py-2 border-b">Lapangan</th>
                        <th class="px-4 py-2 border-b">DP</th>
                        <th class="px-4 py-2 border-b">Harga</th>
                        <th class="px-4 py-2 border-b">Sisa Bayar</th>
                        <th class="px-4 py-2 border-b">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemesanan as $item)
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border">{{ $item->kode_pemesanan }}</td>
                            <td class="py-2 px-4 border">{{ $item->nama_tim }}</td>
                            <td class="py-2 px-4 border">{{ $item->tanggal }}</td>
                            <td class="py-2 px-4 border">{{ $item->jam_mulai }}</td>
                            <td class="py-2 px-4 border">{{ $item->jam_selesai }}</td>
                            <td class="py-2 px-4 border">{{ $item->jadwal->lapangan }}</td>
                            <td class="py-2 px-4 border">Rp{{ number_format($item->dp) }}</td>
                            <td class="py-2 px-4 border">Rp{{ number_format($item->harga) }}</td>
                            <td class="py-2 px-4 border">Rp{{ number_format($item->sisa_bayar) }}</td>
                            <td class="py-2 px-4 border">
                                <span
                                    class="badge {{ $item->status == 'lunas' ? 'bg-green-500' : 'bg-yellow-500' }} text-white py-1 px-2 rounded-md">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-4 text-gray-500">Data pemesanan tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-5 flex justify-end">
            {{ $pemesanan->links('pagination::tailwind') }}
        </div>


    </div>
@endsection
