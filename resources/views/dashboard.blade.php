@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    @if ($showMembershipOffer)
        <div class="alert alert-success mt-3">
            <strong>Selamat!</strong> Kamu telah memesan {{ $bookingCount }} kali.
            Ayo daftar sebagai <strong>Member</strong> dan nikmati diskon serta keistimewaan lainnya!
            <a href="{{ route('member.create') }}" class="btn btn-sm btn-primary mt-2">Daftar Member Sekarang</a>
        </div>
    @endif

    {{-- Penawaran Perpanjangan Membership --}}
    @if ($showRenewalOffer)
        <div class="alert alert-warning mt-3">
            <strong>Keanggotaanmu telah berakhir pada
                {{ \Carbon\Carbon::parse($member->tanggal_berakhir)->format('d M Y') }}.</strong><br>
            Ayo perpanjang sekarang dan lanjutkan nikmati benefit member!
            <a href="{{ route('member.create') }}" class="btn btn-sm btn-warning mt-2">Perpanjang Membership</a>
        </div>
    @endif
    <div class="rounded-lg bg-white p-5 shadow">
        <h1 class="text-2xl font-semibold text-gray-800">
            Halo, {{ Auth::user()->name }}! Selamat datang di Aplikasi Pemesanan Mini Soccer Kramat Jaya.
        </h1>
        <p class="mt-2 text-gray-600">
            Temukan jadwal yang tersedia dan pesan lapangan dengan mudah. Selamat bermain!
        </p>
        <a href="{{ route('jadwal.index') }}"
            class="lazy-loading mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
            <i class="fas fa-calendar-alt mr-2"></i> Lihat Jadwal
        </a>
    </div>
@endsection
