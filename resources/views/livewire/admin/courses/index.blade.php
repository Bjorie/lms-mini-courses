<div class="py-8">
    <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

        @if (session()->has('success'))
            <div
                class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800"
                role="alert"
            >
                {{ session('success') }}
            </div>
        @endif

        <section class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                    Управление курсами
                </h1>

                <p class="mt-1 text-sm text-gray-600">
                    Создавайте, редактируйте и наполняйте учебные курсы.
                </p>
            </div>

            <a
                href="{{ route('admin.courses.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                Создать курс
            </a>
        </section>

        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            @if ($courses->isEmpty())
                <div class="px-6 py-16 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-50 text-blue-600">
                        <svg
                            class="h-6 w-6"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5V5.5A2.5 2.5 0 0 1 6.5 3H20v14H6.5A2.5 2.5 0 0 0 4 19.5Z" />
                        </svg>
                    </div>

                    <h2 class="mt-4 text-lg font-semibold text-gray-900">
                        Курсов пока нет
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Создайте первый курс и добавьте в него разделы и уроки.
                    </p>

                    <a
                        href="{{ route('admin.courses.create') }}"
                        class="mt-6 inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                    >
                        Создать курс
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Название
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Категория
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Автор
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Уровень
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Цена
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Статус
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Публикация
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Действия
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($courses as $course)
                                <tr
                                    wire:key="course-{{ $course->id }}"
                                    class="transition hover:bg-gray-50"
                                >
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="font-semibold text-gray-900">
                                            {{ $course->title }}
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                        {{ $course->category?->name ?? '—' }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                        {{ $course->author?->name ?? '—' }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        @switch($course->level)
                                            @case('beginner')
                                                <span class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                                    Начальный
                                                </span>
                                                @break

                                            @case('intermediate')
                                                <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                                    Средний
                                                </span>
                                                @break

                                            @case('advanced')
                                                <span class="inline-flex rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">
                                                    Продвинутый
                                                </span>
                                                @break

                                            @default
                                                <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                                    —
                                                </span>
                                        @endswitch
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
                                        @if ((float) $course->price > 0)
                                            {{ number_format($course->price, 2, ',', ' ') }} €
                                        @else
                                            <span class="inline-flex rounded-full bg-sky-100 px-2.5 py-1 text-xs font-semibold text-sky-700">
                                                Бесплатно
                                            </span>
                                        @endif
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        @if ($course->published_at)
                                            <span class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                                Опубликован
                                            </span>
                                        @else
                                            <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                                Черновик
                                            </span>
                                        @endif
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                        {{ $course->published_at?->format('d.m.Y') ?? '—' }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-right">
                                        <div class="flex flex-wrap justify-end gap-2">
                                            <a
                                                href="{{ route('admin.courses.edit', $course) }}"
                                                class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
                                            >
                                                Изменить
                                            </a>

                                            <a
                                                href="{{ route('admin.courses.builder', $course) }}"
                                                class="inline-flex items-center rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-sm font-medium text-blue-700 transition hover:bg-blue-100"
                                            >
                                                Конструктор
                                            </a>

                                            <button
                                                type="button"
                                                wire:click="delete({{ $course->id }})"
                                                wire:confirm="Удалить курс «{{ $course->title }}»?"
                                                wire:loading.attr="disabled"
                                                wire:target="delete({{ $course->id }})"
                                                class="inline-flex items-center rounded-lg border border-red-200 bg-white px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-50"
                                            >
                                                Удалить
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
</div>