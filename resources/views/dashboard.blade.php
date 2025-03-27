@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="rounded-lg bg-white p-5 shadow">
        <h1 class="text-2xl font-semibold text-gray-800">
            Halo, {{ Auth::user()->name }}! Selamat datang di Aplikasi Pemesanan Mini Soccer Kramat Jaya.
        </h1>
        <p class="mt-2 text-gray-600">
            Temukan jadwal yang tersedia dan pesan lapangan dengan mudah. Selamat bermain!
        </p>
        <a href="{{ route('jadwal.index') }}" class="lazy-loading mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
            <i class="fas fa-calendar-alt mr-2"></i> Lihat Jadwal
        </a>
    </div>
@endsection
