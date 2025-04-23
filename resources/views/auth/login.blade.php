<x-guest-layout>
    <div class="flex flex-col md:flex-row bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl w-full">
        <!-- Gambar Full Sekotak -->
        <div class="md:w-1/2 h-64 md:h-auto bg-emerald-500">
            <img src="{{ asset('images/logo_kj.png') }}" alt="Gambar Login" class="object-cover w-full h-full">
        </div>

        <!-- Form Login -->
        <div class="md:w-1/2 w-full p-8 md:p-20">
            @if (session('status'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Masuk ke Akun Anda</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email atau Username -->
                <div class="mb-4">
                    <label for="login" class="block text-sm font-medium text-gray-700">
                        {{ __('Email atau Username') }}
                    </label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input id="login" name="login" type="text" value="{{ old('login') }}" required autofocus
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    </div>
                    @error('login')
                        <div class="text-sm text-red-600 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kata Sandi -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        {{ __('Kata Sandi') }}
                    </label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    </div>
                    @error('password')
                        <div class="text-sm text-red-600 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- <!-- Ingat Saya -->
                <div class="flex items-center mb-4">
                    <input id="remember_me" name="remember" type="checkbox"
                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                        {{ __('Ingat Saya') }}
                    </label>
                </div> --}}

                <!-- Aksi -->
                <div class="flex items-center justify-between">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="underline text-sm text-gray-600 hover:text-gray-900">
                            {{ __('Lupa kata sandi Anda?') }}
                        </a>
                    @endif

                    <button type="submit"
                        class="ml-3 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-indigo-700">
                        {{ __('Masuk') }}
                    </button>
                </div>
            </form>

            <!-- Redirect Daftar -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    {{ __('Belum punya akun?') }}
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-900">
                        {{ __('Daftar') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>

