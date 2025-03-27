@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="w-[27rem] md:w-full xl:w-full">
        <div class="max-w-full overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="table-auto w-full text-center text-sm text-gray-700">
                <thead class="bg-emerald-600">
                    <tr class="text-white">
                        <th class="px-4 py-2 border-b">Kode Tim</th>
                        <th class="px-4 py-2 border-b">Nama Tim</th>
                        <th class="px-4 py-2 border-b">Point</th>
                        <th class="px-4 py-2 border-b">Nominal Cashback</th>
                        <th class="px-4 py-2 border-b">Kode Voucher</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rewards as $reward)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 border-b">{{ $reward->kode_tim }}</td>
                            <td class="px-4 py-2 border-b">{{ $reward->nama_tim }}</td>
                            <td class="px-4 py-2 border-b">{{ $reward->point }}</td>
                            <td class="px-4 py-2 border-b">Rp{{ number_format($reward->idr, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border-b">{{ $reward->kode_voucher ?? '-' }}</td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="py-4 text-gray-500">Data reward point tidak ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
