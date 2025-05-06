<nav class="bg-gradient-to-r from-green-700 to-green-900 text-white shadow-xl sticky top-0 z-50 transition-all duration-300">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Logo dan nama -->
            <div class="flex items-center space-x-3">
                <div class="bg-white p-1 rounded-full shadow-md">
                    <img src="{{ asset('images/logo_kj.png') }}" alt="Logo Kramat Jaya" class="h-9 w-9">
                </div>
                <span class="font-bold text-xl md:text-2xl tracking-tight">
                    <span class="text-white">Minisoccer</span>
                    <span class="text-green-300">KJ</span>
                </span>
            </div>

            <!-- Menu tengah (desktop) -->
            <div class="hidden md:flex space-x-8">
                <a href="/" class="font-medium hover:text-green-300 transition duration-200 relative group">
                    Home
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-300 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="/informasi" class="font-medium hover:text-green-300 transition duration-200 relative group">
                    Informasi
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-300 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="/tatacara-pemesanan" class="font-medium hover:text-green-300 transition duration-200 relative group">
                    Tata Cara Pemesanan
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-300 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>

            <!-- Auth buttons (desktop) -->
            @if (Route::has('login'))
                <div class="hidden md:flex space-x-4 items-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-green-600 hover:bg-green-500 text-white font-medium py-2 px-4 rounded-lg transition duration-300 shadow-md">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-medium hover:text-green-300 transition duration-200">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-500 text-white font-medium py-2 px-4 rounded-lg transition duration-300 shadow-md">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <!-- Menu toggle (mobile) -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-white focus:outline-none bg-green-800 p-2 rounded-lg hover:bg-green-700 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu dropdown -->
        <div id="mobile-menu" class="md:hidden hidden pb-4 space-y-3 pt-2 border-t border-green-600 mt-2">
            <a href="#home" class=" py-2 px-3 hover:bg-green-800 rounded-lg transition duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Home
            </a>
            <a href="#informasi" class="py-2 px-3 hover:bg-green-800 rounded-lg transition duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Informasi
            </a>
            <a href="#pemesanan" class=" py-2 px-3 hover:bg-green-800 rounded-lg transition duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                </svg>
                Tata Cara Pemesanan
            </a>
            
            @if (Route::has('login'))
                <div class="border-t border-green-600 pt-2 mt-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class=" py-2 px-3 bg-green-600 hover:bg-green-500 rounded-lg transition duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class=" py-2 px-3 hover:bg-green-800 rounded-lg transition duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="mt-2 py-2 px-3 bg-green-600 hover:bg-green-500 rounded-lg transition duration-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
</nav>

<script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function () {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
    
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('nav');
        if (window.scrollY > 50) {
            navbar.classList.add('py-2', 'shadow-2xl');
            navbar.classList.remove('py-4');
        } else {
            navbar.classList.add('py-4');
            navbar.classList.remove('py-2', 'shadow-2xl');
        }
    });
</script>