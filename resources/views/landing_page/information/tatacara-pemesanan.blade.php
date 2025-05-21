@extends('landing_page.utama') 

@section('content')
<section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-14">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Cara Melakukan Pemesanan Lapangan di Minisoccer KJ</h1>
            <div class="w-24 h-1 bg-rose-500 mx-auto mb-6"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Ikuti langkah-langkah di bawah ini untuk melakukan pemesanan lapang di Minisoccer KJ dengan mudah dan cepat.</p>
        </div>

        <!-- Steps Section -->
        <div class="relative">
            <!-- Timeline Line (for desktop) -->
            <div class="hidden lg:block absolute top-0 bottom-0 left-1/2 w-0.5 bg-gray-200 transform -translate-x-1/2"></div>

            <!-- Steps -->
            <div class="space-y-12 lg:space-y-0">
                <!-- Step 1 -->
                <div class="lg:grid lg:grid-cols-2 lg:gap-6 relative">
                    <!-- Timeline Dot (for desktop) -->
                    <div class="hidden lg:block absolute left-1/2 top-8 transform -translate-x-1/2 z-10">
                        <div class="bg-rose-500 text-white rounded-full w-12 h-12 flex items-center justify-center font-bold text-xl shadow-md">1</div>
                    </div>
                    
                    <!-- Left Content (Even steps) -->
                    <div class="lg:text-right lg:pr-10">
                        <div class="bg-white rounded-xl shadow-sm p-6 mb-4 lg:mb-0 border border-gray-100 transition-all hover:shadow-md">
                            <div class="lg:hidden inline-flex mb-4 bg-rose-500 text-white rounded-full w-10 h-10 items-center justify-center font-bold text-lg">1</div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Punya Akun</h3>
                            <p class="text-gray-600">Untuk melakukan pemesanan, Anda harus memiliki akun terlebih dahulu. Jika Anda belum memiliki akun, silakan <a href="{{ route('register') }}" class="text-rose-600 font-medium hover:text-rose-700">daftar</a> terlebih dahulu. Jika Anda sudah memiliki akun, Anda dapat langsung <a href="{{ route('login') }}" class="text-rose-600 font-medium hover:text-rose-700">login</a>.</p>
                        </div>
                    </div>
                    
                    <!-- Right Image (Now visible on mobile too) -->
                    <div class="mb-4 lg:mb-0 lg:pl-10">
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden h-64 transition-all hover:shadow-md">
                            <img src="{{ asset('images/register.png') }}" alt="Pilih Produk" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="lg:grid lg:grid-cols-2 lg:gap-6 relative">
                    <!-- Timeline Dot (for desktop) -->
                    <div class="hidden lg:block absolute left-1/2 top-8 transform -translate-x-1/2 z-10">
                        <div class="bg-rose-500 text-white rounded-full w-12 h-12 flex items-center justify-center font-bold text-xl shadow-md">2</div>
                    </div>
                    
                    <!-- Left Image (Now visible on mobile too) -->
                    <div class="mb-4 lg:mb-0 lg:pr-10">
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden h-64 transition-all hover:shadow-md">
                            <img src="{{ asset('images/jadwal.png') }}" alt="Buka Menu Jadwal" class="w-full h-full object-cover">
                        </div>
                    </div>
                    
                    <!-- Right Content (Odd steps) -->
                    <div class="lg:pl-10">
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 transition-all hover:shadow-md">
                            <div class="lg:hidden inline-flex mb-4 bg-rose-500 text-white rounded-full w-10 h-10 items-center justify-center font-bold text-lg">2</div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Buka Menu Jadwal</h3>
                            <p class="text-gray-600">Untuk melihat jadwal lapangan secara langsung, silakan buka menu "Jadwal" di sisi kiri . Anda dapat melihat jadwal lapangan yang tersedia beserta dengan waktu dan tanggal yang sesuai. Jika Anda telah menemukan jadwal yang kosong, klik tombol "Tambah Pesanan" yang terletak di sisi kanan.</p>
                            <div class="mt-6">
                                <span class="inline-flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Mudah dilakukan
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="lg:grid lg:grid-cols-2 lg:gap-6 relative">
                    <!-- Timeline Dot (for desktop) -->
                    <div class="hidden lg:block absolute left-1/2 top-8 transform -translate-x-1/2 z-10">
                        <div class="bg-rose-500 text-white rounded-full w-12 h-12 flex items-center justify-center font-bold text-xl shadow-md">3</div>
                    </div>
                    
                    <!-- Left Content (Even steps) -->
                    <div class="lg:text-right lg:pr-10">
                        <div class="bg-white rounded-xl shadow-sm p-6 mb-4 lg:mb-0 border border-gray-100 transition-all hover:shadow-md">
                            <div class="lg:hidden inline-flex mb-4 bg-rose-500 text-white rounded-full w-10 h-10 items-center justify-center font-bold text-lg">3</div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Isi Formulir Pemesanan</h3>
                            <p class="text-gray-600">Setelah mengklik tombol "Tambah Pemesanan", Anda akan diarahkan ke formulir pemesanan. Silakan lengkapi formulir tersebut dengan informasi yang diperlukan sesuai keinginan Anda. Pastikan untuk memilih jadwal yang kosong sesuai preferensi Anda, lalu klik tombol "Pesan" untuk menyelesaikan proses pemesanan.</p>
                            <div class="mt-6 flex lg:justify-end">
                                <span class="inline-flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                    <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Data aman
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Image (Now visible on mobile too) -->
                    <div class="mb-4 lg:mb-0 lg:pl-10">
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden h-64 transition-all hover:shadow-md">
                            <img src="{{ asset('images/form_pemesanan.png') }}" alt="Lengkapi Data" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="lg:grid lg:grid-cols-2 lg:gap-6 relative">
                    <!-- Timeline Dot (for desktop) -->
                    <div class="hidden lg:block absolute left-1/2 top-8 transform -translate-x-1/2 z-10">
                        <div class="bg-rose-500 text-white rounded-full w-12 h-12 flex items-center justify-center font-bold text-xl shadow-md">4</div>
                    </div>
                    
                    <!-- Left Image (Now visible on mobile too) -->
                    <div class="mb-4 lg:mb-0 lg:pr-10">
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden h-64 transition-all hover:shadow-md">
                            <img src="{{ asset('images/metode_pembayaran.png') }}" alt="Pilih Metode Pembayaran" class="w-full h-full object-cover">
                        </div>
                    </div>
                    
                    <!-- Right Content (Odd steps) -->
                    <div class="lg:pl-10">
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 transition-all hover:shadow-md">
                            <div class="lg:hidden inline-flex mb-4 bg-rose-500 text-white rounded-full w-10 h-10 items-center justify-center font-bold text-lg">4</div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Pilih Cara Pembayaran</h3>
                            <p class="text-gray-600">Setelah Anda klik tombol "Tambah Pemesanan", Anda akan diarahkan ke halaman pembayaran digital yang aman dan nyaman. Pilih cara pembayaran yang Anda sukai dan ikuti petunjuk selanjutnya untuk menyelesaikan proses pemesanan.</p>
                            <div class="mt-6 flex flex-wrap gap-2">
                                <img src="/api/placeholder/40/25" alt="Kartu Kredit" class="h-6 object-contain">
                                <img src="/api/placeholder/40/25" alt="Transfer Bank" class="h-6 object-contain">
                                <img src="/api/placeholder/40/25" alt="Dompet Digital" class="h-6 object-contain">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="lg:grid lg:grid-cols-2 lg:gap-6 relative">
                    <!-- Timeline Dot (for desktop) -->
                    <div class="hidden lg:block absolute left-1/2 top-8 transform -translate-x-1/2 z-10">
                        <div class="bg-rose-500 text-white rounded-full w-12 h-12 flex items-center justify-center font-bold text-xl shadow-md">5</div>
                    </div>
                    
                    <!-- Left Content (Even steps) -->
                    <div class="lg:text-right lg:pr-10">
                        <div class="bg-white rounded-xl shadow-sm p-6 mb-4 lg:mb-0 border border-gray-100 transition-all hover:shadow-md">
                            <div class="lg:hidden inline-flex mb-4 bg-rose-500 text-white rounded-full w-10 h-10 items-center justify-center font-bold text-lg">5</div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Pemesanan Berhasil!</h3>
                            <p class="text-gray-600">Setelah Anda melewati 4 step diatas maka pemesanan Anda sudah berhasil dan Anda akan diarahkan ke halaman detail pemesanan. Di sana Anda akan melihat data pemesanan yang ada dan Anda dapat langsung bermain dengan melakukan pelunasan sesudah selesai bermain.</p>
                            <div class="mt-6 flex lg:justify-end">
                                <span class="inline-flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                    </svg>
                                    Pemesanan Berhasil!
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Image (Now visible on mobile too) -->
                    <div class="mb-4 lg:mb-0 lg:pl-10">
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden h-64 transition-all hover:shadow-md">
                            <img src="{{ asset('images/pemesanan_selesai.png') }}" alt="Konfirmasi Pesanan" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CTA Section -->
        <div class="mt-16 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-green-900 mb-6">Siap untuk memesan lapangan?</h2>
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-green-600 text-white px-6 py-3 rounded-lg text-lg font-medium hover:bg-green-700 transition-colors shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                Mulai Pemesanan Sekarang
            </a>
        </div>
    </div>
</section>
@endsection