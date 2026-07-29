<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">

    <header class="mb-6">
        <h2 class="text-xl font-semibold text-red-600">
            Удаление аккаунта
        </h2>

        <p class="mt-2 text-sm text-gray-600">
            После удаления аккаунта будут безвозвратно удалены все ваши данные,
            записи о прохождении курсов и настройки профиля. Это действие нельзя отменить.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        Удалить аккаунт
    </x-danger-button>

    <x-modal
        name="confirm-user-deletion"
        :show="$errors->isNotEmpty()"
        focusable
    >
        <form wire:submit="deleteUser" class="p-6">

            <h2 class="text-xl font-semibold text-gray-900">
                Подтверждение удаления аккаунта
            </h2>

            <p class="mt-3 text-sm leading-6 text-gray-600">
                Для подтверждения удаления введите текущий пароль.
                После удаления восстановить аккаунт будет невозможно.
            </p>

            <div class="mt-6">
                <x-input-label
                    for="password"
                    value="Пароль"
                />

                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="Введите пароль"
                    autocomplete="current-password"
                />

                <x-input-error
                    :messages="$errors->get('password')"
                    class="mt-2"
                />
            </div>

            <div class="mt-8 flex justify-end gap-3">

                <x-secondary-button
                    x-on:click="$dispatch('close')"
                >
                    Отмена
                </x-secondary-button>

                <x-danger-button>
                    Удалить аккаунт
                </x-danger-button>

            </div>

        </form>
    </x-modal>

</section>
