@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="container mx-auto px-4 mt-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Membership Offer --}}
            @if ($showMembershipOffer)
                <div id="membership-offer"
                    class="bg-green-100 border-l-4 border-green-500 text-green-700 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">🎉 Selamat!</h3>
                    <p>Selamat! Kamu sudah memesan <strong>{{ $bookingCount }}</strong> kali di Minisoccer Kramat Jaya.</p>
                    <p>Sebagai apresiasi, kami ingin menawarkanmu diskon dan keistimewaan lainnya jika kamu daftar sebagai
                        <strong>Member</strong> di Minisoccer Kramat Jaya.
                    </p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ URL::signedRoute('member.create') }}"
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm font-medium">
                            Pesan Lapang Sebagai Member
                        </a>
                        <button onclick="hideOffer('membership-offer')"
                            class="text-green-700 border border-green-500 hover:bg-green-200 px-4 py-2 rounded text-sm font-medium">
                            Nanti saja
                        </button>
                    </div>
                </div>
            @endif

            {{-- Renewal Offer --}}
            @if ($showRenewalOffer)
                <div id="renewal-offer"
                    class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">⏳ Membership Berakhir</h3>
                    <p>Keanggotaanmu telah berakhir pada
                        <strong>{{ \Carbon\Carbon::parse($member->tanggal_berakhir)->format('d M Y') }}</strong>.
                    </p>
                    <p>Ayo perpanjang sekarang dan lanjutkan nikmati benefit member!</p>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ URL::signedRoute('member.create') }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm font-medium">
                            Perpanjang Membership
                        </a>
                        <button onclick="hideOffer('renewal-offer')"
                            class="text-yellow-800 border border-yellow-500 hover:bg-yellow-200 px-4 py-2 rounded text-sm font-medium">
                            Nanti saja
                        </button>
                    </div>
                </div>
            @endif



            <div
                class="p-4 bg-blue-500 text-white rounded-lg shadow-lg transition-transform transform hover:scale-105 self-start">

                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold">Saldo cashback</h2>
                        <p class="text-3xl font-bold">Rp {{ number_format($idr, 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-coins text-4xl mr-4"></i>
                </div>
                <a href="{{ route('reward.index') }}"
                    class="mt-4 block text-white text-sm font-semibold underline items-center">
                    Lihat data <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div
                class="p-4 bg-orange-500 text-white rounded-lg shadow-lg transition-transform transform hover:scale-105 self-start">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold">Pemesanan Mendatang</h2>
                        <p class="text-3xl font-bold">{{ $jumlahPemesananMendatang }}</p>
                    </div>
                    <i class="fas fa-calendar-alt text-4xl mr-4"></i>
                </div>
                <a href="{{ route('pemesanan.detail') }}"
                    class="mt-4 block text-white text-sm font-semibold underline items-center">
                    Lihat data <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="p-4 bg-indigo-500 text-white rounded-lg shadow-lg transition-transform transform hover:scale-105">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold">Status Member</h2>
                        <p class="text-3xl font-bold">{{ $memberStatus }}</p>
                    </div>
                    <i class="fas fa-user-check text-4xl mr-4"></i>
                </div>
            </div>
            <!-- Bagian daftar harga lapangan yang sudah diperbaiki -->
            <div
                class="p-6 bg-gradient-to-br from-blue-100 to-emerald-400 rounded-xl shadow-lg border border-blue-200 col-span-1 md:col-span-3">
                <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-3 rounded-lg mr-4">
                        <i class="fas fa-clipboard-list text-white text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Daftar Harga Lapangan</h2>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Harga Siang Hari -->
                    <div
                        class="bg-white rounded-xl p-6 border-l-4 border-yellow-400 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center mb-4">
                            <div class="bg-yellow-100 p-3 rounded-full mr-3">
                                <i class="fas fa-sun text-yellow-600 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">Siang Hari</h3>
                                <p class="text-sm text-gray-600">07.00 - 17.00 WIB</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-700 font-medium">Lapangan 1, 2, 3</span>
                                <span class="text-lg font-bold text-green-600">Rp 300.000</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-700 font-medium">Lapangan 4, 5</span>
                                <span class="text-lg font-bold text-green-600">Rp 350.000</span>
                            </div>
                        </div>

                        <div class="mt-4 p-2 bg-yellow-50 rounded-lg">
                            <p class="text-xs text-yellow-700 text-center">
                                <i class="fas fa-info-circle mr-1"></i>
                                Harga per jam
                            </p>
                        </div>
                    </div>

                    <!-- Harga Malam Hari -->
                    <div
                        class="bg-white rounded-xl p-6 border-l-4 border-purple-400 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-100 p-3 rounded-full mr-3">
                                <i class="fas fa-moon text-purple-600 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">Malam Hari</h3>
                                <p class="text-sm text-gray-600">17.00 - 23.00 WIB</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-700 font-medium">Lapangan 1, 2, 3</span>
                                <span class="text-lg font-bold text-green-600">Rp 400.000</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-700 font-medium">Lapangan 4, 5</span>
                                <span class="text-lg font-bold text-green-600">Rp 450.000</span>
                            </div>
                        </div>

                        <div class="mt-4 p-2 bg-purple-50 rounded-lg">
                            <p class="text-xs text-purple-700 text-center">
                                <i class="fas fa-info-circle mr-1"></i>
                                Harga per jam
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Informasi tambahan -->
                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-start">
                        <i class="fas fa-lightbulb text-blue-500 text-lg mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-semibold text-blue-800 mb-2">Informasi Pemesanan</h4>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Minimal pemesanan 1 jam</li>
                                <li>• Pembayaran uang muka hanya dapat dilakukan secara transfer untuk lokasi yang jauh </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    <script>
        function hideOffer(id) {
            const element = document.getElementById(id);
            if (element) {
                element.style.display = 'none';
            }
        }
    </script>
