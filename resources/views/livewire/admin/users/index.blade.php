<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">
            Пользователи
        </h1>

        <p class="mt-2 text-gray-600">
            Управление пользователями платформы и их ролями.
        </p>
    </div>

    @if (session('success'))
        <div
            class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800"
            role="alert"
        >
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div
            class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800"
            role="alert"
        >
            {{ session('error') }}
        </div>
    @endif

    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">
                Всего пользователей
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-900">
                {{ $usersCount }}
            </p>
        </div>

        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">
                Студентов
            </p>

            <p class="mt-2 text-3xl font-bold text-green-600">
                {{ $studentsCount }}
            </p>
        </div>

        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">
                Авторов
            </p>

            <p class="mt-2 text-3xl font-bold text-blue-600">
                {{ $authorsCount }}
            </p>
        </div>

        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">
                Администраторов
            </p>

            <p class="mt-2 text-3xl font-bold text-red-600">
                {{ $adminsCount }}
            </p>
        </div>
    </div>

    <div class="rounded-xl border bg-white shadow-sm">
        <div class="border-b px-6 py-5">
            <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_220px_140px_auto] lg:items-end">
                <div>
                    <label
                        for="users-search"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Поиск
                    </label>

                    <div class="relative">
                        <svg
                            class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M9 3.5a5.5 5.5 0 1 0 3.473 9.768l3.63 3.63a.75.75 0 0 0 1.06-1.06l-3.63-3.63A5.5 5.5 0 0 0 9 3.5ZM5 9a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z"
                                clip-rule="evenodd"
                            />
                        </svg>

                        <input
                            wire:model.live.debounce.350ms="search"
                            id="users-search"
                            type="search"
                            placeholder="Имя или электронная почта"
                            class="block w-full rounded-lg border-gray-300 py-2.5 pl-10 pr-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>
                </div>

                <div>
                    <label
                        for="users-role"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Роль
                    </label>

                    <select
                        wire:model.live="role"
                        id="users-role"
                        class="block w-full rounded-lg border-gray-300 py-2.5 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="">Все роли</option>
                        <option value="admin">Администраторы</option>
                        <option value="author">Авторы</option>
                        <option value="student">Студенты</option>
                    </select>
                </div>

                <div>
                    <label
                        for="users-per-page"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        На странице
                    </label>

                    <select
                        wire:model.live="perPage"
                        id="users-per-page"
                        class="block w-full rounded-lg border-gray-300 py-2.5 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>

                <div>
                    <button
                        type="button"
                        wire:click="$set('search', ''); $set('role', '')"
                        @if ($search === '' && $role === '') disabled @endif
                        class="inline-flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50 lg:w-auto"
                    >
                        Сбросить
                    </button>
                </div>
            </div>
        </div>

        <div
            wire:loading.delay
            wire:target="search, role, perPage, updateRole, delete"
            class="border-b bg-indigo-50 px-6 py-3 text-sm font-medium text-indigo-700"
        >
            Обновление данных...
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Пользователь
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Роль
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Курсов
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Регистрация
                        </th>

                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Действия
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($users as $user)
                        @php
                            $currentRole = $user->roles->first()?->name ?? 'student';

                            $roleLabel = match ($currentRole) {
                                'admin' => 'Администратор',
                                'author' => 'Автор',
                                default => 'Студент',
                            };

                            $roleClasses = match ($currentRole) {
                                'admin' => 'bg-red-100 text-red-700',
                                'author' => 'bg-blue-100 text-blue-700',
                                default => 'bg-green-100 text-green-700',
                            };
                        @endphp

                        <tr
                            wire:key="user-{{ $user->id }}"
                            class="transition hover:bg-gray-50"
                        >
                            <td class="px-6 py-4">
                                <div class="flex min-w-64 items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold uppercase text-indigo-700">
                                        {{ mb_substr($user->name, 0, 1) }}
                                    </div>

                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <p class="truncate font-semibold text-gray-900">
                                                {{ $user->name }}
                                            </p>

                                            @if ($user->id === auth()->id())
                                                <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-600">
                                                    Вы
                                                </span>
                                            @endif
                                        </div>

                                        <p class="mt-0.5 truncate text-sm text-gray-500">
                                            {{ $user->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="space-y-2">
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $roleClasses }}">
                                        {{ $roleLabel }}
                                    </span>

                                    <select
                                        wire:change="updateRole({{ $user->id }}, $event.target.value)"
                                        class="block min-w-44 rounded-lg border-gray-300 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        aria-label="Изменить роль пользователя {{ $user->name }}"
                                    >
                                        <option value="admin" @selected($currentRole === 'admin')>
                                            Администратор
                                        </option>

                                        <option value="author" @selected($currentRole === 'author')>
                                            Автор
                                        </option>

                                        <option value="student" @selected($currentRole === 'student')>
                                            Студент
                                        </option>
                                    </select>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $user->enrolled_courses_count }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                {{ $user->created_at?->format('d.m.Y') ?? '—' }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <button
                                    type="button"
                                    wire:click="delete({{ $user->id }})"
                                    wire:confirm="Удалить пользователя «{{ $user->name }}»? Это действие нельзя отменить."
                                    @disabled($user->id === auth()->id())
                                    class="inline-flex items-center rounded-lg border border-red-200 bg-white px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-40"
                                >
                                    Удалить
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center">
                                <div class="mx-auto max-w-sm">
                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-500">
                                        <svg
                                            class="h-6 w-6"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path d="M10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.5 17.25a6.5 6.5 0 0 1 13 0 .75.75 0 0 1-.75.75H4.25a.75.75 0 0 1-.75-.75Z" />
                                        </svg>
                                    </div>

                                    <h3 class="mt-4 font-semibold text-gray-900">
                                        Пользователи не найдены
                                    </h3>

                                    <p class="mt-2 text-sm text-gray-500">
                                        Измените поисковый запрос или выбранный фильтр.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="border-t px-6 py-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>