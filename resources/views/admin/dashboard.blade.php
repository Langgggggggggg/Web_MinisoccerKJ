@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="container mx-auto px-4">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Total Users -->
            <div class="p-4 bg-blue-500 text-white rounded-lg shadow-lg transition-transform transform hover:scale-105">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold">Total Penyewa</h2>
                        <p class="text-3xl font-bold">{{ $totalUsers }}</p>
                    </div>
                    <i class="fas fa-users text-4xl mr-4"></i>
                </div>
                <a href="{{ route('user.data-user') }}" class="mt-4 block text-white text-sm font-semibold underline items-center">
                    Lihat data <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <!-- Total Pemesanan Belum Lunas -->
            <div class="p-4 bg-red-500 text-white rounded-lg shadow-lg transition-transform transform hover:scale-105">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold">Pemesanan Belum Lunas Hari Ini</h2>
                        <p class="text-3xl font-bold">{{ $totalBelumLunas }}</p>
                    </div>
                    <i class="fas fa-exclamation-circle text-4xl"></i>
                </div>
                <a href="{{ route('admin.data-pemesanan') }}" class="mt-4 block text-white text-sm font-semibold underline items-center">
                    Lihat data <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <!-- Total Pendapatan Bulan Ini -->
            <div class="p-4 bg-yellow-500 text-white rounded-lg shadow-lg transition-transform transform hover:scale-105">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold">Pendapatan Bulan Ini</h2>
                        <p class="text-3xl font-bold">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-money-bill-wave text-4xl mr-4"></i>
                </div>
                <a href="{{ route('admin.keuangan') }}" class="mt-4 block text-white text-sm font-semibold underline items-center">
                    Lihat detail <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <!-- Total Pendapatan Minggu ini -->
            <div class="p-4 bg-teal-500 text-white rounded-lg shadow-lg transition-transform transform hover:scale-105">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold">Pendapatan Minggu Ini</h2>
                        <p class="text-3xl font-bold">Rp {{ number_format($pendapatanMingguIni, 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-wallet text-4xl mr-4"></i>
                </div>
                <a href="{{ route('admin.keuangan') }}" class="mt-4 block text-white text-sm font-semibold underline items-center">
                    Lihat detail <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <!-- Total Pengajuan Refund -->
            <div class="p-4 bg-purple-500 text-white rounded-lg shadow-lg transition-transform transform hover:scale-105">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold">Pengajuan Pembatalan</h2>
                        <p class="text-3xl font-bold">{{ $totalPengajuanRefund }}</p>
                    </div>
                    <i class="fas fa-undo-alt text-4xl mr-4"></i>
                </div>
                <a href="{{ route('admin.refunds.index') }}" class="mt-4 block text-white text-sm font-semibold underline items-center">
                    Lihat data <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

        </div>
    </div>
@endsection
