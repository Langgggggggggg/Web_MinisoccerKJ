<x-guest-layout>
    <div class="flex flex-col md:flex-row bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl w-full">
        <!-- Gambar Full Sekotak -->
        <div class="md:w-1/2 h-64 md:h-auto bg-emerald-500">
            <img src="{{ asset('images/logo_kj.png') }}" alt="Forgot Password Image" class="object-cover w-full h-full">
        </div>

        <!-- Form Forgot Password -->
        <div class="md:w-1/2 w-full p-8 md:p-20">
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Lupa kata sandi Anda? Tidak masalah. Tinggal beritahu kami alamat email Anda dan kami akan mengirimkan tautan reset kata sandi yang akan memungkinkan Anda memilih kata sandi baru.') }}
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        {{ __('Email') }}
                    </label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    </div>
                    @error('email')
                        <div class="text-sm text-red-600 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-4 space-x-3">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-indigo-700">
                        {{ __('Reset Kata Sandi') }}
                    </button>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-gray-700 text-sm hover:bg-gray-400">
                        {{ __('Kembali') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

