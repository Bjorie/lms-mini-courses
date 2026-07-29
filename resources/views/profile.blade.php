<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Профиль
                </h1>

                <p class="mt-1 text-sm text-gray-600">
                    Управление личными данными и безопасностью аккаунта.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-5xl space-y-6">

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <livewire:profile.update-profile-information-form />
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <livewire:profile.update-password-form />
            </div>

            <div class="rounded-xl border border-red-200 bg-white p-6 shadow-sm">
                <livewire:profile.delete-user-form />
            </div>

        </div>
    </div>
</x-app-layout>