<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class,
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        // Назначаем роль студента каждому новому пользователю.
        $user->assignRole('student');

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(
            route('dashboard', absolute: false),
            navigate: true
        );
    }
}; ?>

<div>
    <div class="text-center">
        <h1 class="text-2xl font-bold tracking-tight text-slate-950">
            Создание аккаунта
        </h1>

        <p class="mt-2 text-sm leading-6 text-slate-600">
            Зарегистрируйтесь, чтобы получить доступ к учебным курсам.
        </p>
    </div>

    <form wire:submit="register" class="mt-7 space-y-5">
        <div>
            <x-input-label
                for="name"
                value="Имя"
                class="font-semibold text-slate-700"
            />

            <x-text-input
                wire:model="name"
                id="name"
                class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                type="text"
                name="name"
                placeholder="Введите ваше имя"
                required
                autofocus
                autocomplete="name"
            />

            <x-input-error
                :messages="$errors->get('name')"
                class="mt-2"
            />
        </div>

        <div>
            <x-input-label
                for="email"
                value="Электронная почта"
                class="font-semibold text-slate-700"
            />

            <x-text-input
                wire:model="email"
                id="email"
                class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                type="email"
                name="email"
                placeholder="name@example.com"
                required
                autocomplete="username"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />
        </div>

        <div>
            <x-input-label
                for="password"
                value="Пароль"
                class="font-semibold text-slate-700"
            />

            <x-text-input
                wire:model="password"
                id="password"
                class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                type="password"
                name="password"
                placeholder="Придумайте пароль"
                required
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />
        </div>

        <div>
            <x-input-label
                for="password_confirmation"
                value="Подтверждение пароля"
                class="font-semibold text-slate-700"
            />

            <x-text-input
                wire:model="password_confirmation"
                id="password_confirmation"
                class="mt-2 block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                type="password"
                name="password_confirmation"
                placeholder="Повторите пароль"
                required
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"
            />
        </div>

        <button
            type="submit"
            wire:loading.attr="disabled"
            wire:target="register"
            class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60"
        >
            <span wire:loading.remove wire:target="register">
                Создать аккаунт
            </span>

            <span wire:loading wire:target="register">
                Создание аккаунта...
            </span>
        </button>
    </form>

    <p class="mt-7 text-center text-sm text-slate-600">
        Уже есть аккаунт?

        <a
            href="{{ route('login') }}"
            wire:navigate
            class="font-semibold text-blue-600 transition hover:text-blue-700"
        >
            Войти
        </a>
    </p>
</div>