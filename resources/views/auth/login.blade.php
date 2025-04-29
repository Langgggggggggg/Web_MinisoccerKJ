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

            <!-- Divider dengan text -->
            <div class="relative flex py-5 items-center">
                <div class="flex-grow border-t border-gray-300"></div>
                <span class="flex-shrink mx-4 text-gray-500 text-sm">atau</span>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>

            <!-- Google Login Button -->
            <div class="mb-4">
                <a href="{{ route('auth.google') }}" 
                   class="flex items-center justify-center w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                        <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
                        <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
                        <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
                        <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                    </svg>
                    Masuk dengan Google
                </a>
            </div>

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