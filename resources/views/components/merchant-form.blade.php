<x-form-section submit="handleSubmitMerchant">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Full Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Full Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.fullname" required autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="role" value="{{ __('Role') }}" />
            <x-input id="role" type="text" class="mt-1 block w-full" wire:model="state.role" required autocomplete="role" disabled />
            <x-input-error for="role" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>