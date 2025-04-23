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
                        <h2 class="text-lg font-semibold">Total Pengguna</h2>
                        <p class="text-3xl font-bold">{{ $totalUsers }}</p>
                    </div>
                    <i class="fas fa-users text-4xl mr-4"></i>
                </div>
                <a href="{{ route('user.data-user') }}" class="mt-4 block text-white text-sm font-semibold underline items-center">
                    Lihat data <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>


            <!-- Total Admin -->

            <div class="p-4 bg-green-500 text-white rounded-lg shadow-lg transition-transform transform hover:scale-105">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold">Total Admin</h2>
                        <p class="text-3xl font-bold">{{ $totalAdmin }}</p>
                    </div>
                    <i class="fas fa-user-shield text-4xl mr-4"></i>
                </div>
                <a href="{{ route('admin.data-admin') }}" class="mt-4 block text-white text-sm font-semibold underline items-center">
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
                    <i class="fas fa-exclamation-circle  text-4xl"></i>
                </div>
                <a href="{{ route('admin.data-pemesanan') }}"
                    class="mt-4 block text-white text-sm font-semibold underline items-center">
                    Lihat data <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>


        </div>
    </div>
@endsection
