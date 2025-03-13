<header class="w-full bg-white shadow-md p-6 mb-4">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">
            @php
                if (request()->routeIs('dashboard')) {
                    echo 'Home';
                } elseif (request()->routeIs('jadwal.index')) {
                    echo 'Jadwal';
                } elseif (request()->routeIs('pemesanan.detail')) {
                    echo 'Detail Pemesanan';
                } elseif (request()->routeIs('admin.dashboard')) {
                    echo 'Admin Dashboard';
                } elseif (request()->routeIs('profile.edit')) {
                    echo 'Profile';
                } else {
                    echo 'Mini Soccer Kramat Jaya';
                }
        @endphp
        </h1>
        <div class="relative">
            <details class="group">
                <summary
                    class="flex items-center space-x-2 cursor-pointer px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 bg-white hover:text-gray-700">
                    <span>{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 transition-transform group-open:rotate-180" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </summary>
                <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Log Out
                        </button>
                    </form>
                </div>
            </details>
        </div>
    </div>
</header>
