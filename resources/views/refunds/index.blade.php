@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="w-[19rem] md:w-full xl:w-full">
        <div class="max-w-full overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="table-auto w-full text-center text-sm text-gray-700">
                    <thead class="bg-emerald-600">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Kode Pemesanan
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Lapangan
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Jam Bermain
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Uang yang sudah dibayar
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Alasan
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                Bukti Transfer
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if (count($refunds) > 0)
                            @foreach ($refunds as $refund)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $refund->kode_pemesanan ?? (optional($refund->pemesanan)->kode_pemesanan ?? '-') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $refund->lapangan ?? (optional(optional($refund->pemesanan)->jadwal)->lapangan ?? '-') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $refund->tanggal ?? (optional(optional($refund->pemesanan)->jadwal)->tanggal ?? '-') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $refund->jam_bermain ??
                                                ($refund->pemesanan ? $refund->pemesanan->jam_mulai . ' - ' . $refund->pemesanan->jam_selesai : '-') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $refund->idr ?? ($refund->pemesanan ? $refund->pemesanan->idr : '-') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($refund->status == 'diajukan')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Diajukan
                                            </span>
                                        @elseif($refund->status == 'disetujui')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Disetujui
                                            </span>
                                        @elseif($refund->status == 'ditolak')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Ditolak
                                            </span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ ucfirst($refund->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $refund->alasan ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($refund->bukti_transfer)
                                            <a href="{{ asset('storage/' . $refund->bukti_transfer) }}" target="_blank"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Lihat
                                            </a>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="px-6 py-12 whitespace-nowrap text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-3"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="text-gray-600 font-medium">Belum ada pengajuan refund</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            <!-- Pagination if needed -->
            @if (isset($refunds) && method_exists($refunds, 'links'))
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                    {{ $refunds->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
