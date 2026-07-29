<div class="mx-auto max-w-7xl space-y-8 px-4 py-8 sm:px-6 lg:px-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">
            Панель администратора
        </h1>

        <p class="mt-2 text-gray-600">
            Обзор состояния платформы обучения.
        </p>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">
                Курсов
            </p>

            <p class="mt-2 text-3xl font-bold">
                {{ $coursesCount }}
            </p>
        </div>

        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">
                Опубликовано
            </p>

            <p class="mt-2 text-3xl font-bold text-green-600">
                {{ $publishedCoursesCount }}
            </p>
        </div>

        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">
                Студентов
            </p>

            <p class="mt-2 text-3xl font-bold text-blue-600">
                {{ $studentsCount }}
            </p>
        </div>

        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">
                Записей
            </p>

            <p class="mt-2 text-3xl font-bold text-purple-600">
                {{ $enrollmentsCount }}
            </p>
        </div>
    </div>

    <div class="grid gap-8 lg:grid-cols-3">
        <div class="rounded-xl border bg-white shadow-sm lg:col-span-2">
            <div class="border-b px-6 py-4">
                <h2 class="text-lg font-semibold">
                    Последние курсы
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Курс
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Автор
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Статус
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Создан
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($latestCourses as $course)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $course->title }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $course->author?->name ?? '—' }}
                                </td>

                                <td class="px-6 py-4">
                                    @if ($course->published_at)
                                        <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-700">
                                            Опубликован
                                        </span>
                                    @else
                                        <span class="rounded-full bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-700">
                                            Черновик
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $course->created_at->format('d.m.Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    Курсов пока нет.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold">
                Быстрые действия
            </h2>

            <div class="mt-6 space-y-3">
                <a
                    href="{{ route('admin.courses.create') }}"
                    class="block rounded-lg bg-indigo-600 px-4 py-3 text-center font-medium text-white transition hover:bg-indigo-700"
                >
                    ➕ Новый курс
                </a>

                <a
                    href="{{ route('admin.courses.index') }}"
                    class="block rounded-lg border px-4 py-3 text-center transition hover:bg-gray-50"
                >
                    📚 Все курсы
                </a>

                <a
                    href="{{ route('admin.categories.index') }}"
                    class="block rounded-lg border px-4 py-3 text-center transition hover:bg-gray-50"
                >
                    🏷 Категории
                </a>

                <a
                    href="{{ route('admin.users.index') }}"
                    class="block rounded-lg border px-4 py-3 text-center transition hover:bg-gray-50"
                >
                    👥 Пользователи
                </a>

                <a
                        href="{{ $latestCourses->isNotEmpty()
                                ? route('admin.courses.builder', $latestCourses->first())
                                : '#' }}"
                    @class([
                        'block rounded-lg border px-4 py-3 text-center transition',
                        'hover:bg-gray-50' => $latestCourses->isNotEmpty(),
                        'pointer-events-none opacity-50' => $latestCourses->isEmpty(),
                    ])
                >
                    🛠 Конструктор курса
                </a>
            </div>
        </div>
    </div>
</div>