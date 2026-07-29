<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>

    <header class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900">
            Личные данные
        </h2>

        <p class="mt-2 text-sm text-gray-600">
            Здесь вы можете изменить имя и адрес электронной почты.
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="space-y-6">

        <div>
            <x-input-label for="name" value="Имя" />

            <x-text-input
                wire:model="name"
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full"
                required
                autofocus
                autocomplete="name"
            />

            <x-input-error
                class="mt-2"
                :messages="$errors->get('name')"
            />
        </div>

        <div>
            <x-input-label
                for="email"
                value="Электронная почта"
            />

            <x-text-input
                wire:model="email"
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                required
                autocomplete="username"
            />

            <x-input-error
                class="mt-2"
                :messages="$errors->get('email')"
            />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())

                <div class="mt-4 rounded-lg border border-amber-200 bg-amber-50 p-4">

                    <p class="text-sm text-amber-800">
                        Адрес электронной почты ещё не подтверждён.
                    </p>

                    <button
                        type="button"
                        wire:click.prevent="sendVerification"
                        class="mt-3 text-sm font-medium text-indigo-600 hover:text-indigo-700"
                    >
                        Отправить письмо повторно
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-green-600">
                            Ссылка для подтверждения успешно отправлена.
                        </p>
                    @endif

                </div>

            @endif

        </div>

        <div class="flex items-center gap-4 pt-2">

            <x-primary-button>
                Сохранить изменения
            </x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                Изменения сохранены.
            </x-action-message>

        </div>

    </form>

</section>