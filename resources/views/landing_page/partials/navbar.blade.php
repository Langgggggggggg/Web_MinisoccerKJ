<nav class="bg-gradient-to-r from-green-700 to-green-900 text-white shadow-xl sticky top-0 z-50 transition-all duration-300">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Logo and brand name -->
            <div class="flex items-center space-x-3">
                <div class="bg-white p-1.5 rounded-full shadow-md transform hover:scale-105 transition duration-300">
                    <img src="{{ asset('images/logo_kj.png') }}" alt="Logo Kramat Jaya" class="h-8 w-8">
                </div>
                <span class="font-bold text-xl md:text-2xl tracking-tight">
                    <span class="text-white">Minisoccer</span>
                    <span class="text-green-300 font-extrabold">KJ</span>
                </span>
            </div>

            <!-- Desktop menu -->
            <div class="hidden md:flex space-x-10">
                <a href="/" class="font-medium hover:text-green-300 transition duration-200 relative group flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Home
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-300 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="/informasi" class="font-medium hover:text-green-300 transition duration-200 relative group flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Informasi
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-300 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="/tatacara-pemesanan" class="font-medium hover:text-green-300 transition duration-200 relative group flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                    Tata Cara Pemesanan
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-300 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>

            <!-- Auth buttons (desktop) -->
            @if (Route::has('login'))
                <div class="hidden md:flex space-x-4 items-center">
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ url('/admin/dashboard') }}" class="bg-green-600 hover:bg-green-500 text-white font-medium py-2 px-4 rounded-lg transition duration-300 shadow-md flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ url('/dashboard') }}" class="bg-green-600 hover:bg-green-500 text-white font-medium py-2 px-4 rounded-lg transition duration-300 shadow-md flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="font-medium hover:text-green-300 transition duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-500 text-white font-medium py-2 px-4 rounded-lg transition duration-300 shadow-md flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            @endif

            <!-- Mobile menu toggle -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-white focus:outline-none bg-green-800 hover:bg-green-700 p-2 rounded-lg transition duration-200 flex items-center shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu dropdown -->
        <div id="mobile-menu" class="md:hidden hidden pb-4 space-y-3 pt-3 border-t border-green-600 mt-2 animate-fadeIn">
            <a href="/" class="py-2 px-3 hover:bg-green-800 rounded-lg transition duration-200 flex items-center group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="group-hover:translate-x-1 transition-transform duration-200">Home</span>
            </a>
            <a href="/informasi" class="py-2 px-3 hover:bg-green-800 rounded-lg transition duration-200 flex items-center group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="group-hover:translate-x-1 transition-transform duration-200">Informasi</span>
            </a>
            <a href="/tatacara-pemesanan" class="py-2 px-3 hover:bg-green-800 rounded-lg transition duration-200 flex items-center group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                </svg>
                <span class="group-hover:translate-x-1 transition-transform duration-200">Tata Cara Pemesanan</span>
            </a>
            
            @if (Route::has('login'))
                <div class="border-t border-green-600 pt-3 mt-3 space-y-2">
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ url('/admin/dashboard') }}" class="bg-green-600 hover:bg-green-500 text-white font-medium py-2 px-4 rounded-lg transition duration-300 shadow-md flex items-center w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ url('/dashboard') }}" class="bg-green-600 hover:bg-green-500 text-white font-medium py-2 px-4 rounded-lg transition duration-300 shadow-md flex items-center w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="py-2 px-3 hover:bg-green-800 rounded-lg transition duration-200 flex items-center w-full group">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="group-hover:translate-x-1 transition-transform duration-200">Log in</span>
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-500 text-white font-medium py-2 px-4 rounded-lg transition duration-300 shadow-md flex items-center w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }
</style>

<script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function () {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
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
