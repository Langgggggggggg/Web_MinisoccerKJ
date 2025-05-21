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
                        <strong>Member</strong> di Minisoccer Kramat Jaya.</p>
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
