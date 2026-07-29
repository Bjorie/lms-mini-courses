<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(
            default: route('dashboard', absolute: false),
            navigate: true
        );
    }
}; ?>

<div>
    <div class="text-center">
        <h1 class="text-2xl font-bold tracking-tight text-slate-950">
            Вход в систему
        </h1>

        <p class="mt-2 text-sm leading-6 text-slate-600">
            Введите данные своей учётной записи, чтобы продолжить обучение.
        </p>
    </div>

    <x-auth-session-status
        class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800"
        :status="session('status')"
    />

    <form wire:submit="login" class="mt-7 space-y-5">
        <div>
            <x-input-label
                for="email"
                value="Электронная почта"
                class="font-semibold text-slate-700"
            />

            <x-text-input
                wire:model="form.email"
                id="email"
                class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                type="email"
                name="email"
                placeholder="name@example.com"
                required
                autofocus
                autocomplete="username"
            />

            <x-input-error
                :messages="$errors->get('form.email')"
                class="mt-2"
            />
        </div>

        <div>
            <div class="flex items-center justify-between gap-4">
                <x-input-label
                    for="password"
                    value="Пароль"
                    class="font-semibold text-slate-700"
                />

                @if (Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        wire:navigate
                        class="text-sm font-semibold text-blue-600 transition hover:text-blue-700"
                    >
                        Забыли пароль?
                    </a>
                @endif
            </div>

            <x-text-input
                wire:model="form.password"
                id="password"
                class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                type="password"
                name="password"
                placeholder="Введите пароль"
                required
                autocomplete="current-password"
            />

            <x-input-error
                :messages="$errors->get('form.password')"
                class="mt-2"
            />
        </div>

        <label for="remember" class="flex cursor-pointer items-center gap-3">
            <input
                wire:model="form.remember"
                id="remember"
                type="checkbox"
                name="remember"
                class="h-4 w-4 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500"
            >

            <span class="text-sm text-slate-600">
                Запомнить меня
            </span>
        </label>

        <button
            type="submit"
            wire:loading.attr="disabled"
            wire:target="login"
            class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60"
        >
            <span wire:loading.remove wire:target="login">
                Войти
            </span>

            <span wire:loading wire:target="login">
                Выполняется вход...
            </span>
        </button>
    </form>

    @if (Route::has('register'))
        <p class="mt-7 text-center text-sm text-slate-600">
            Ещё нет аккаунта?

            <a
                href="{{ route('register') }}"
                wire:navigate
                class="font-semibold text-blue-600 transition hover:text-blue-700"
            >
                Зарегистрироваться
            </a>
        </p>
    @endif
</div>