<section class="w-full md:w-[42rem] lg:w-[42rem] xl:w-[72rem] md:mx-auto lg:mx-auto mt-5 bg-white shadow-md p-3">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">
            @php
                if (request()->routeIs('dashboard')) {
                    echo '<i class="fas fa-home mr-2"></i> Home';
                } elseif (request()->routeIs('jadwal.index')) {
                    echo '<i class="fas fa-calendar-alt mr-2"></i> Jadwal';
                } elseif (request()->routeIs('pemesanan.detail')) {
                    echo '<i class="fas fa-file-alt mr-2"></i> Detail Pemesanan';
                } elseif (request()->routeIs('admin.dashboard')) {
                    echo '<i class="fas fa-user-shield mr-2"></i> Admin Dashboard';
                } elseif (request()->routeIs('profile.edit')) {
                    echo '<i class="fas fa-user-edit mr-2"></i> Profile';
                } else if (request()->routeIs('pemesanan.create')) {
                    echo '<i class="fas fa-calendar-alt mr-2"></i>Form Pemesanan';
                }
                    else {
                    echo '<i class="fas fa-futbol mr-2"></i> Mini Soccer Kramat Jaya';
                }
            @endphp
        </h1>
        <div class="relative">
            <details class="group">
                <summary
                    class="flex items-center space-x-2 cursor-pointer px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 bg-white hover:text-gray-700">
                    <span><i class="fas fa-user mr-2"></i>
                        {{ Auth::user()->name }}
                    </span>
                    <svg class="w-4 h-4 transition-transform group-open:rotate-180" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </summary>
                <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                     Profile
                    </a>
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
</section>
