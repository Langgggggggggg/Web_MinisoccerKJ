<div class="relative md:flex">
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
                    class="block rounded px-4 py-2.5 transition duration-200 hover:bg-emerald-600 hover:text-white {{ request()->routeIs('dashboard') ? 'bg-emerald-600' : '' }}">
                    Home
                </a>
                <a href="{{ route('jadwal.index') }}"
                    class="block rounded px-4 py-2.5 transition duration-200 hover:bg-emerald-600 hover:text-white {{ request()->routeIs('jadwal.index') ? 'bg-emerald-600' : '' }}">
                    Jadwal
                </a>
                <a href="{{ route('pemesanan.detail') }}"
                    class="block rounded px-4 py-2.5 transition duration-200 hover:bg-emerald-600 hover:text-white {{ request()->routeIs('pemesanan.detail') ? 'bg-emerald-600' : '' }}">
                    Detail Pemesanan
                </a>
            @endif

            @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="block rounded px-4 py-2.5 transition duration-200 hover:bg-emerald-600 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600' : '' }}">
                    Admin Dashboard
                </a>
            @endif
        </nav>
    </aside>
</div>

