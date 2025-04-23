<x-guest-layout>
    <div class="flex flex-col-reverse sm:flex-col-reverse md:flex-row bg-white shadow-lg rounded-lg overflow-hidden w-full lg:h-[39rem] max-w-4xl mx-auto">
        <!-- Form -->
        <div class="w-full md:w-1/2 p-6 sm:p-8 md:p-2 lg:p-9 xl:p-10 order-1 md:order-1 overflow-y-auto max-h-full" style="scrollbar-width: none;">
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-6 text-gray-800 text-center">Buat Akun Anda</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nama -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-user"></i>
                        </span>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    </div>
                    @error('name')
                        <div class="text-sm text-red-600 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Username -->
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Nama Pengguna</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-id-badge"></i>
                        </span>
                        <input id="username" name="username" type="text" value="{{ old('username') }}" required autocomplete="username"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    </div>
                    @error('username')
                        <div class="text-sm text-red-600 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    </div>
                    @error('email')
                        <div class="text-sm text-red-600 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    </div>
                    @error('password')
                        <div class="text-sm text-red-600 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    </div>
                    @error('password_confirmation')
                        <div class="text-sm text-red-600 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Aksi -->
                <div class="flex items-center justify-between mt-4">
                    <a href="{{ route('login') }}"
                        class="underline text-sm text-gray-600 hover:text-gray-900">
                        {{ __('Sudah Punya Akun?') }}
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Daftar') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Gambar -->
        <div class="w-full md:w-[40rem] h-52 sm:h-64 md:h-auto order-2 md:order-2 bg-emerald-500">
            <img src="{{ asset('images/logo_kj.png') }}" alt="Gambar Daftar" class="object-cover w-full h-full">
        </div>
    </div>
</x-guest-layout>

