<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            <i class="fas fa-user-cog mr-2"></i> {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui informasi profil dan alamat email akun Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Name Input -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <div class="flex items-center border border-gray-300 rounded-lg">
                <i class="fas fa-user text-gray-400 mx-3"></i>
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full pl-10" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Username Input -->
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <div class="flex items-center border border-gray-300 rounded-lg">
                <i class="fas fa-user-tag text-gray-400 mx-3"></i>
                <x-text-input id="username" name="username" type="text" class="mt-1 block w-full pl-10" :value="old('username', $user->username)" required autocomplete="username" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>
        
        <!-- Email Input -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <div class="flex items-center border border-gray-300 rounded-lg">
                <i class="fas fa-envelope text-gray-400 mx-3"></i>
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full pl-10" :value="old('email', $user->email)" required autocomplete="username" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <x-primary-button>
                <i class="fas fa-save mr-2"></i> {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
