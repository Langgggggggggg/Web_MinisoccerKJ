@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection
@section('content')
<div class="max-w-2xl mx-auto mt-12 mb-12">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
            <h2 class="text-2xl font-bold text-white text-center">Pengajuan Refund</h2>
        </div>
        
        <!-- Booking Information -->
        <div class="p-6">
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Detail Pemesanan
                </h3>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Kode Pemesanan</p>
                            <p class="text-base font-semibold text-gray-800">{{ $pemesanan->kode_pemesanan }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Lapangan</p>
                            <p class="text-base font-semibold text-gray-800">{{ $pemesanan->jadwal->lapangan }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tanggal</p>
                            <p class="text-base font-semibold text-gray-800">{{ $pemesanan->jadwal->tanggal }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Jam Bermain</p>
                            <p class="text-base font-semibold text-gray-800">{{ $pemesanan->jam_mulai . ' - ' . $pemesanan->jam_selesai }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Uang muka yang sudah dibayar</p>
                            <p class="text-base font-semibold text-gray-800">{{ $pemesanan->dp }}</p>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Refund Form -->
            <form method="POST" action="{{ route('refunds.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="pemesanan_id" value="{{ $pemesanan->id }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="alasan">
                        Alasan Pengajuan Refund:
                    </label>
                    <div class="relative">
                        <textarea 
                            name="alasan" 
                            id="alasan" 
                            rows="4" 
                            required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 resize-none transition-colors duration-200"
                            placeholder="Jelaskan alasan Anda mengajukan refund..."
                        ></textarea>
                    </div>
                </div>
                
                <div class="flex items-center justify-end pt-4">
                    <a href="{{ route('pemesanan.detail') }}" class="px-5 py-2 mr-3 text-gray-700 font-medium bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 transition duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batalkan
                    </a>
                    <button type="submit" class="px-5 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection