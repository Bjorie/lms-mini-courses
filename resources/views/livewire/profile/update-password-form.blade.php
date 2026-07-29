<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900">
            Смена пароля
        </h2>

        <p class="mt-2 text-sm text-gray-600">
            Используйте надёжный пароль, содержащий буквы, цифры и специальные символы.
        </p>
    </header>

    <form wire:submit="updatePassword" class="space-y-6">

        <div>
            <x-input-label
                for="update_password_current_password"
                value="Текущий пароль"
            />

            <x-text-input
                wire:model="current_password"
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="mt-1 block w-full"
                autocomplete="current-password"
            />

            <x-input-error
                :messages="$errors->get('current_password')"
                class="mt-2"
            />
        </div>

        <div>
            <x-input-label
                for="update_password_password"
                value="Новый пароль"
            />

            <x-text-input
                wire:model="password"
                id="update_password_password"
                name="password"
                type="password"
                class="mt-1 block w-full"
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />
        </div>

        <div>
            <x-input-label
                for="update_password_password_confirmation"
                value="Подтверждение нового пароля"
            />

            <x-text-input
                wire:model="password_confirmation"
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-1 block w-full"
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"
            />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button>
                Сохранить изменения
            </x-primary-button>

            <x-action-message on="password-updated">
                Пароль успешно изменён.
            </x-action-message>
        </div>

    </form>
</section>
