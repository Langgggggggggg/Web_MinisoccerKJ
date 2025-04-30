@extends('layouts.app')
@section('header')
    @include('layouts.header')
@endsection

@section('content')
<div class="max-w-4xl mx-auto mt-8 mb-12 px-4 sm:px-0">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.refunds.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Refund
        </a>
    </div>

    <!-- Header -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Detail Pengajuan Refund</h2>
        </div>

        <!-- Main Content -->
        <div class="p-6">
            <!-- Refund Status Badge -->
            <div class="mb-6 flex justify-between items-center">
                <div class="font-medium">
                    Status: 
                    @if($refund->status == 'diajukan')
                        <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-sm font-medium">Diajukan</span>
                    @elseif($refund->status == 'disetujui')
                        <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-sm font-medium">Disetujui</span>
                    @elseif($refund->status == 'ditolak')
                        <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-sm font-medium">Ditolak</span>
                    @endif
                </div>
            </div>

            <!-- Information Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Informasi Pengguna
                    </h3>
                    <div class="space-y-2">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Pengguna</p>
                            <p class="text-base font-semibold text-gray-800">{{ $refund->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Tim</p>
                            <p class="text-base font-semibold text-gray-800">{{ $refund->pemesanan->nama_tim ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Detail Pemesanan
                    </h3>
                    <div class="space-y-2">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Kode Pemesanan</p>
                            <p class="text-base font-semibold text-gray-800">{{ $refund->kode_pemesanan ?? optional($refund->pemesanan)->kode_pemesanan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Lapangan</p>
                            <p class="text-base font-semibold text-gray-800">{{ $refund->lapangan ?? optional(optional($refund->pemesanan)->jadwal)->lapangan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tanggal</p>
                            <p class="text-base font-semibold text-gray-800">{{ $refund->tanggal ?? optional(optional($refund->pemesanan)->jadwal)->tanggal ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Jam Bermain</p>
                            <p class="text-base font-semibold text-gray-800">{{ $refund->jam_bermain ?? ($refund->pemesanan ? $refund->pemesanan->jam_mulai . ' - ' . $refund->pemesanan->jam_selesai : '-') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Uang muka yang sudah dibayar</p>
                            <p class="text-base font-semibold text-gray-800">{{ $refund->dp ?? ($refund->pemesanan ? $refund->pemesanan->dp : '-') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alasan Section -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 mb-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    Alasan Pengajuan
                </h3>
                <div class="bg-white rounded p-3 border border-gray-200 mt-2">
                    <p class="text-gray-700">{{ $refund->alasan ?? '-' }}</p>
                </div>
            </div>

            <!-- Conditional Status Sections -->
            @if($refund->status == 'diajukan')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Approve Form -->
                    <div class="bg-white rounded-lg border border-gray-200 p-5">
                        <h3 class="text-lg font-semibold text-green-600 mb-4">Setujui Refund</h3>
                        <form method="POST" action="{{ route('admin.refunds.approve', $refund->id) }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label for="bukti_transfer" class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Transfer:</label>
                                <input type="file" name="bukti_transfer" id="bukti_transfer" required
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                                Setujui Refund
                            </button>
                        </form>
                    </div>

                    <!-- Reject Form -->
                    <div class="bg-white rounded-lg border border-gray-200 p-5">
                        <h3 class="text-lg font-semibold text-red-600 mb-4">Tolak Refund</h3>
                        <form method="POST" action="{{ route('admin.refunds.reject', $refund->id) }}" class="space-y-4">
                            @csrf
                            <div>
                                <label for="alasan" class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan:</label>
                                <textarea name="alasan" id="alasan" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
                            </div>
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                                Tolak Refund
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($refund->status == 'disetujui')
                <div class="bg-green-50 rounded-lg p-5 border border-green-200">
                    <h3 class="text-lg font-semibold text-green-700 mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Refund Disetujui
                    </h3>
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-2">Bukti Transfer:</p>
                        <a href="{{ asset('storage/'.$refund->bukti_transfer) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Lihat Bukti Transfer
                        </a>
                    </div>
                </div>
            @elseif($refund->status == 'ditolak')
                <div class="bg-red-50 rounded-lg p-5 border border-red-200">
                    <h3 class="text-lg font-semibold text-red-700 mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Refund Ditolak
                    </h3>
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-2">Alasan Penolakan:</p>
                        <div class="bg-white rounded p-3 border border-gray-200">
                            <p class="text-gray-700">{{ $refund->alasan }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection