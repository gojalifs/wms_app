<x-guest-layout>
    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-300 text-yellow-900 rounded text-sm">
        {{ __('wms.change_password.notice') }}
    </div>

    <form method="POST" action="{{ route('password.change.update') }}">
        @csrf

        <div class="mb-4">
            <x-input-label for="password" :value="__('wms.change_password.new_password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password"
                          class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="password_confirmation" :value="__('wms.change_password.confirm_password')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                          autocomplete="new-password" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('wms.change_password.submit') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
