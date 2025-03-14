<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            <i class="fas fa-key mr-2"></i> {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk menjaga keamanannya.") }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Current Password Input -->
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <div class="flex items-center border border-gray-300 rounded-lg">
                <i class="fas fa-lock text-gray-400 mx-3"></i>
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full pl-10" autocomplete="current-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password Input -->
        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <div class="flex items-center border border-gray-300 rounded-lg">
                <i class="fas fa-key text-gray-400 mx-3"></i>
                <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full pl-10" autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password Input -->
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <div class="flex items-center border border-gray-300 rounded-lg">
                <i class="fas fa-check-circle text-gray-400 mx-3"></i>
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full pl-10" autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <x-primary-button>
                <i class="fas fa-save mr-2"></i> {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
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
