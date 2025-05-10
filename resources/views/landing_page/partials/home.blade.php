@extends('landing_page.utama')

@section('content')
    <!-- Hero Section with Modern Design -->
    <section id="home" class="relative">
        <div class="w-full h-[600px] bg-cover bg-center relative overflow-hidden"
            style="background-image: url('{{ asset('images/lapangkj.jpg') }}')">
            <!-- Overlay Gradient -->
            <div class="absolute inset-0 bg-gradient-to-r from-green-900/80 via-black/60 to-black/70 flex items-center">
                <div class="container mx-auto px-4">
                    <div class="max-w-xl ml-4 md:ml-12 lg:ml-16">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight">
                            <span class="block">Minisoccer</span>
                            <span class="text-green-400">Kramat Jaya</span>
                        </h1>
                        <p class="text-xl text-gray-200 mt-4 mb-8">Lapangan berkualitas premium untuk pengalaman bermain
                            sepak bola terbaik Anda</p>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('login') }}"
                                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Pesan Sekarang
                            </a>
                            <a href="#fasilitas"
                                class="bg-transparent border-2 border-white hover:border-green-400 text-white hover:text-green-400 font-semibold py-3 px-6 rounded-lg transition duration-300">
                                Lihat Fasilitas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Counter Section -->
    <section class="bg-green-50">
        <div class="container mx-auto py-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-4">
                    <div class="text-4xl font-bold text-green-600">5</div>
                    <div class="text-gray-600 mt-1">Lapangan Premium</div>
                </div>
                <div class="text-center p-4">
                    <div class="text-4xl font-bold text-green-600">16</div>
                    <div class="text-gray-600 mt-1">Jam Operasional</div>
                </div>
                <div class="text-center p-4">
                    <div class="text-4xl font-bold text-green-600">1000+</div>
                    <div class="text-gray-600 mt-1">Pelanggan Puas</div>
                </div>
                <div class="text-center p-4">
                    <div class="text-4xl font-bold text-green-600">4.9</div>
                    <div class="text-gray-600 mt-1">Rating Pengguna</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Section with Better Visual Hierarchy -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-green-600 font-medium">KEUNGGULAN KAMI</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-2">Mengapa Memilih Kami?</h2>
                <div class="w-20 h-1 bg-green-500 mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-b-4 border-green-500 group hover:-translate-y-2">
                    <div
                        class="bg-green-100 text-green-600 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto group-hover:bg-green-600 group-hover:text-white transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-center mt-6 mb-3">5 Lapangan Premium</h3>
                    <p class="text-gray-600 text-center">Tersedia 5 lapangan berkualitas tinggi dengan rumput sintetis
                        terbaik untuk pengalaman bermain yang optimal.</p>
                </div>

                <div
                    class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-b-4 border-green-500 group hover:-translate-y-2">
                    <div
                        class="bg-green-100 text-green-600 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto group-hover:bg-green-600 group-hover:text-white transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-center mt-6 mb-3">Pemesanan Online</h3>
                    <p class="text-gray-600 text-center">Anda dapat memesan lapangan secara online melalui website kami
                        tanpa perlu datang langsung ke lokasi. Anda dapat memesan lapangan kapanpun dan dimanapun Anda
                        berada.</p>
                </div>

                <div
                    class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-b-4 border-green-500 group hover:-translate-y-2">
                    <div
                        class="bg-green-100 text-green-600 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto group-hover:bg-green-600 group-hover:text-white transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-center mt-6 mb-3">Reward Point</h3>
                    <p class="text-gray-600 text-center">Dapatkan cashback tunai dengan mengumpulkan reward point dari
                        setiap transaksi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Price List Section -->
    <section id="harga" class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-green-600 font-medium">BIAYA SEWA</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-2">Daftar Harga</h2>
                <div class="w-20 h-1 bg-green-500 mx-auto mt-4"></div>
                <p class="text-gray-600 mt-4">Jam malam mulai dari pukul 17.00 WIB</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Lapangan 1-3 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
                    <div class="bg-green-600 p-4">
                        <h3 class="text-xl md:text-2xl font-bold text-white text-center">Lapangan 1, 2, 3</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between p-4 border-b">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span class="font-medium">Siang</span>
                            </div>
                            <div class="text-lg font-bold text-green-600">Rp 300.000</div>
                        </div>
                        <div class="flex items-center justify-between p-4">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                                <span class="font-medium">Malam</span>
                            </div>
                            <div class="text-lg font-bold text-green-600">Rp 350.000</div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('login') }}" 
                               class="block w-full text-center bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-300">
                                Pesan Sekarang
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Lapangan 4-5 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
                    <div class="bg-green-700 p-4">
                        <h3 class="text-xl md:text-2xl font-bold text-white text-center">Lapangan 4, 5</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between p-4 border-b">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span class="font-medium">Siang</span>
                            </div>
                            <div class="text-lg font-bold text-green-600">Rp 400.000</div>
                        </div>
                        <div class="flex items-center justify-between p-4">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                                <span class="font-medium">Malam</span>
                            </div>
                            <div class="text-lg font-bold text-green-600">Rp 450.000</div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('login') }}" 
                               class="block w-full text-center bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-300">
                                Pesan Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Price Table -->
            <div class="mt-8 overflow-x-auto md:hidden">
                <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-lg">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="py-3 px-4 text-left">Lapangan</th>
                            <th class="py-3 px-4 text-left">Siang</th>
                            <th class="py-3 px-4 text-left">Malam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="py-3 px-4 font-medium">Lapangan 1</td>
                            <td class="py-3 px-4">Rp 300.000</td>
                            <td class="py-3 px-4">Rp 350.000</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-3 px-4 font-medium">Lapangan 2</td>
                            <td class="py-3 px-4">Rp 300.000</td>
                            <td class="py-3 px-4">Rp 350.000</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-3 px-4 font-medium">Lapangan 3</td>
                            <td class="py-3 px-4">Rp 300.000</td>
                            <td class="py-3 px-4">Rp 350.000</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-3 px-4 font-medium">Lapangan 4</td>
                            <td class="py-3 px-4">Rp 400.000</td>
                            <td class="py-3 px-4">Rp 450.000</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 font-medium">Lapangan 5</td>
                            <td class="py-3 px-4">Rp 400.000</td>
                            <td class="py-3 px-4">Rp 450.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Facilities Section with Modern Cards -->
    <section id="fasilitas" class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-green-600 font-medium">KENYAMANAN TERBAIK</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-2">Fasilitas Unggulan</h2>
                <div class="w-20 h-1 bg-green-500 mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 group">
                    <div class="h-56 bg-cover bg-center relative"
                        style="background-image: url('{{ asset('images/lapang.jpg') }}')">
                        <div class="absolute inset-0 bg-black opacity-10 group-hover:opacity-20 transition duration-300">
                        </div>
                        <div class="absolute bottom-0 left-0 p-4">
                            <span
                                class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">Berkualitas</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2 group-hover:text-green-600 transition duration-300">Lapangan
                            Berkualitas</h3>
                        <p class="text-gray-600">Dilengkapi dengan rumput sintetis premium yang nyaman dan aman untuk
                            bermain.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 group">
                    <div class="h-56 bg-cover bg-center relative"
                        style="background-image: url('{{ asset('images/locker_room.jpg') }}')">
                        <div class="absolute inset-0 bg-black opacity-30 group-hover:opacity-20 transition duration-300">
                        </div>
                        <div class="absolute bottom-0 left-0 p-4">
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">Bersih</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2 group-hover:text-green-600 transition duration-300">Ruang Ganti
                        </h3>
                        <p class="text-gray-600">Ruang ganti yang bersih dan nyaman untuk persiapan sebelum dan sesudah
                            bermain.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 group">
                    <div class="h-56 bg-cover bg-center relative"
                        style="background-image: url('{{ asset('images/Parkiran.jpg') }}')">
                        <div class="absolute inset-0 bg-black opacity-10 group-hover:opacity-20 transition duration-300">
                        </div>
                        <div class="absolute bottom-0 left-0 p-4">
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">Luas</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2 group-hover:text-green-600 transition duration-300">Area Parkir
                            Luas</h3>
                        <p class="text-gray-600">Area parkir yang aman dan luas untuk kendaraan para pengunjung.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 group">
                    <div class="h-56 bg-cover bg-center relative"
                        style="background-image: url('{{ asset('images/istirahat.jpg') }}')">
                        <div class="absolute inset-0 bg-black opacity-10 group-hover:opacity-20 transition duration-300">
                        </div>
                        <div class="absolute bottom-0 left-0 p-4">
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">Nyaman</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2 group-hover:text-green-600 transition duration-300">Area
                            Istirahat</h3>
                        <p class="text-gray-600">Tempat santai untuk beristirahat setelah bermain dengan makanan dan
                            minuman.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 group">
                    <div class="h-56 bg-cover bg-center relative"
                        style="background-image: url('{{ asset('images/lapangmalam.jpg') }}')">
                        <div class="absolute inset-0 bg-black opacity-10 group-hover:opacity-20 transition duration-300">
                        </div>
                        <div class="absolute bottom-0 left-0 p-4">
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">Modern</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2 group-hover:text-green-600 transition duration-300">Pencahayaan
                            Prima</h3>
                        <p class="text-gray-600">Sistem pencahayaan terbaik untuk permainan malam yang tetap nyaman.</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 group">
                    <div class="h-56 bg-cover bg-center relative"
                        style="background-image: url('{{ asset('images/kantin.jpg') }}')">
                        <div class="absolute inset-0 bg-black opacity-10 group-hover:opacity-20 transition duration-300">
                        </div>
                        <div class="absolute bottom-0 left-0 p-4">
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">Lengkap</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2 group-hover:text-green-600 transition duration-300">Kantin</h3>
                        <p class="text-gray-600">Nikmati berbagai pilihan makanan dan minuman yang tersedia di kantin kami.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Location Section -->
    <section id="lokasi" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-green-600 font-medium">TEMUKAN KAMI</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-2">Lokasi Kami</h2>
                <div class="w-20 h-1 bg-green-500 mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                <!-- Map Column (3/5 width on large screens) -->
                <div class="lg:col-span-3 overflow-hidden rounded-xl shadow-lg h-96 md:h-[450px]">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.6180076491626!2d107.59970408654863!3d-6.999479494139025!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e9a38131eed1%3A0x177d1f51e7aaa511!2sMini%20soccer%20KJ!5e0!3m2!1sid!2sid!4v1683467235684!5m2!1sid!2sid"
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full h-full">
                    </iframe>
                </div>

                <!-- Info Column (2/5 width on large screens) -->
                <div class="lg:col-span-2 flex flex-col justify-center">
                    <div class="bg-white p-8 rounded-xl shadow-lg border-l-4 border-green-500">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">Mini Soccer Kramat Jaya</h3>
                        
                        <div class="space-y-4">
                            <!-- Address -->
                            <div class="flex items-start">
                                <div class="text-green-500 mr-4 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700">Alamat</h4>
                                    <p class="text-gray-600">Perum grand apple, Rancamulya, Kec. Pameungpeuk, Kabupaten Bandung, Jawa Barat</p>
                                </div>
                            </div>
                            
                            <!-- Operating Hours -->
                            <div class="flex items-start">
                                <div class="text-green-500 mr-4 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700">Jam Operasional</h4>
                                    <p class="text-gray-600">Setiap Hari: 08.00 - 00.00 WIB</p>
                                </div>
                            </div>
                            
                            <!-- Phone Number -->
                            <div class="flex items-start">
                                <div class="text-green-500 mr-4 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700">Telepon</h4>
                                    <p class="text-gray-600">0817-7084-9902</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Directions Button -->
                        <a href="https://www.google.com/maps/place/Mini+soccer+KJ/@-6.9994795,107.5997041,17z/data=!3m1!4b1!4m6!3m5!1s0x2e68e9a38131eed1:0x177d1f51e7aaa511!8m2!3d-6.9994795!4d107.602279!16s%2Fg%2F11vj43flqq" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="mt-8 inline-flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg w-full sm:w-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                            Petunjuk Arah
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection