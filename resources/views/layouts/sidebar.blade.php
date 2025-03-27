<nav class="relative md:flex">
    <!-- Hamburger Button (Tampil hanya saat sidebar tertutup) -->
    <!-- Tombol Hamburger -->
    <button id="menu-toggle" class="absolute top-0 left-2 z-50 text-black focus:outline-none md:hidden p-2">
        <svg id="hamburger-icon" class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>


    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-40 w-64 space-y-6 bg-emerald-700 px-2 py-7 text-blue-100 transform -translate-x-full transition-transform duration-300 md:relative md:translate-x-0 md:block">
        <!-- Close Button (Tampil hanya saat sidebar terbuka) -->
        <button id="close-menu" class="absolute top-5 right-5 text-white md:hidden">
            <svg id="close-icon" class="w-8 h-8 hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 px-4 text-white">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
            <span class="text-lg font-semibold">Kramat Jaya</span>
        </a>

        <!-- Nav -->
        <nav class="mt-4">
            @if (Auth::user()->role === 'user')
                <a href="{{ route('dashboard') }}"
                    class="sidebar-link block rounded px-4 py-2.5 transition duration-200 hover:bg-emerald-600 hover:text-white {{ request()->routeIs('dashboard') ? 'bg-emerald-600' : '' }}">
                    <i class="fas fa-home w-5 h-5 mr-2"></i> Home
                </a>
                <a href="{{ route('jadwal.index') }}"
                    class="lazy-loading block rounded px-4 py-2.5 transition duration-200 hover:bg-emerald-600 hover:text-white {{ request()->routeIs('jadwal.index') ? 'bg-emerald-600' : '' }}">
                    <i class="fas fa-calendar w-5 h-5 mr-2"></i> Jadwal
                </a>
                <a href="{{ route('pemesanan.detail') }}"
                    class="block rounded px-4 py-2.5 transition duration-200 hover:bg-emerald-600 hover:text-white {{ request()->routeIs('pemesanan.detail') ? 'bg-emerald-600' : '' }}">
                    <i class="fas fa-file-alt w-5 h-5 mr-2"></i> Detail Pemesanan
                </a>
                <a href="{{ route('reward.index') }}"
                    class="block rounded px-4 py-2.5 transition duration-200 hover:bg-emerald-600 hover:text-white {{ request()->routeIs('reward.index') ? 'bg-emerald-600' : '' }}">
                    <i class="fas fa-gift w-5 h-5 mr-2"></i> Reward Point
                </a>
            @endif

            @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="block rounded px-4 py-2.5 transition duration-200 hover:bg-emerald-600 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600' : '' }}">
                    <i class="fas fa-user-shield w-5 h-5 mr-2"></i> Admin Dashboard
                </a>

                <!-- Dropdown Data -->
                <div x-data="{ open: {{ request()->routeIs('admin.data-pemesanan') || request()->routeIs('admin.reward-points') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full rounded px-4 py-2.5 transition duration-200 hover:bg-emerald-600 hover:text-white">
                        <span><i class="fas fa-database w-5 h-5 mr-2"></i> Master Data</span>
                        <i class="fas fa-chevron-down" :class="{ 'rotate-180': open }"></i>
                    </button>

                    <div x-show="open" class="pl-8 mt-2">
                        <a href="{{ route('admin.data-pemesanan') }}"
                            class="block rounded px-4 py-2.5 transition duration-200 hover:bg-emerald-600 hover:text-white {{ request()->routeIs('admin.data-pemesanan') ? 'bg-emerald-600' : '' }}">
                            <i class="fas fa-file-alt w-5 h-5 mr-2"></i> Data Pemesanan
                        </a>
                        <a href="{{ route('admin.reward-points') }}"
                            class="block rounded px-4 py-2.5 transition duration-200 hover:bg-emerald-600 hover:text-white {{ request()->routeIs('admin.reward-points') ? 'bg-emerald-600' : '' }}">
                            <i class="fas fa-gift w-5 h-5 mr-2"></i> Data Reward Points
                        </a>
                    </div>
                </div>

                <!-- Dropdown Konfirmasi/Transaksi -->
                <div x-data="{ open: {{ request()->routeIs('admin.konfirmasi-pelunasan') || request()->routeIs('admin.konfirmasi-penukaran-poin') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full rounded px-4 py-2.5 transition duration-200 hover:bg-emerald-600 hover:text-white">
                        <span><i class="fas fa-check-circle w-5 h-5 mr-2"></i> Konfirmasi</span>
                        <i class="fas fa-chevron-down" :class="{ 'rotate-180': open }"></i>
                    </button>

                    <div x-show="open" class="pl-8 mt-2">
                        <a href="{{ route('admin.konfirmasi-pelunasan') }}"
                            class="block rounded px-4 py-2.5 transition duration-200 hover:bg-emerald-600 hover:text-white {{ request()->routeIs('admin.konfirmasi-pelunasan') ? 'bg-emerald-600' : '' }}">
                            <i class="fas fa-money-check-alt w-5 h-5 mr-2"></i> Konfirmasi Pelunasan
                        </a>
                        <a href="{{ route('admin.konfirmasi-penukaran-poin') }}"
                            class="block rounded px-4 py-2.5 transition duration-200 hover:bg-emerald-600 hover:text-white {{ request()->routeIs('admin.konfirmasi-penukaran-poin') ? 'bg-emerald-600' : '' }}">
                            <i class="fas fa-gift w-5 h-5 mr-2"></i> Konfirmasi Penukaran Poin
                        </a>
                    </div>
                </div>
            @endif

        </nav>
    </aside>
</nav>
