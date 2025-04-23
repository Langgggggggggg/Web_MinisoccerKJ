<header class="bg-blue-500 dark:bg-gray-800 py-4 px-4">
    <nav class="flex items-center justify-between">
        <a href="{{ url('/') }}" class="text-2xl font-bold text-white dark:text-gray-100">
            MinisoccerKj
        </a>
        @if (Route::has('login'))
            <div class="space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-white dark:text-gray-100 hover:underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-white dark:text-gray-100 hover:underline">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-white dark:text-gray-100 hover:underline">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </nav>
</header>
