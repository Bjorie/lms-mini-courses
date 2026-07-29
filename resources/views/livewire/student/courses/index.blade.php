<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            Каталог курсов
        </h1>

        <p class="mt-2 text-gray-600">
            Выберите курс, чтобы посмотреть программу и начать обучение.
        </p>
    </div>

    @if ($courses->isNotEmpty())
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($courses as $course)
                <article
                    wire:key="course-{{ $course->id }}"
                    class="flex h-full flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
                >
                    @if ($course->thumbnail)
                        <a
                            href="{{ route('student.courses.show', $course) }}"
                            wire:navigate
                            class="block"
                        >
                            <img
                                src="{{ asset('storage/' . $course->thumbnail) }}"
                                alt="{{ $course->title }}"
                                class="h-48 w-full object-cover"
                            >
                        </a>
                    @else
                        <a
                            href="{{ route('student.courses.show', $course) }}"
                            wire:navigate
                            class="flex h-48 items-center justify-center bg-gray-100"
                        >
                            <span class="text-sm font-medium text-gray-400">
                                Изображение курса
                            </span>
                        </a>
                    @endif

                    <div class="flex flex-1 flex-col p-6">
                        <div class="flex flex-wrap items-center gap-2">
                            @if ($course->category)
                                <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700">
                                    {{ $course->category->name }}
                                </span>
                            @endif

                            @if ($course->is_enrolled)
                                <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700">
                                    Вы записаны
                                </span>
                            @endif
                        </div>

                        <h2 class="mt-4 text-xl font-semibold text-gray-900">
                            <a
                                href="{{ route('student.courses.show', $course) }}"
                                wire:navigate
                                class="transition hover:text-indigo-600"
                            >
                                {{ $course->title }}
                            </a>
                        </h2>

                        @if ($course->short_description)
                            <p class="mt-3 line-clamp-3 text-sm leading-6 text-gray-600">
                                {{ $course->short_description }}
                            </p>
                        @endif

                        <div class="mt-4 text-sm text-gray-500">
                            <span>
                                Автор:
                                <span class="font-medium text-gray-700">
                                    {{ $course->author?->name ?? 'Не указан' }}
                                </span>
                            </span>
                        </div>

                        <div class="mt-auto pt-6">
                            <a
                                href="{{ route('student.courses.show', $course) }}"
                                wire:navigate
                                class="inline-flex w-full items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                @if ($course->is_enrolled)
                                    Продолжить обучение
                                @else
                                    Подробнее о курсе
                                @endif
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $courses->links() }}
        </div>
    @else
        <div class="rounded-xl border border-dashed border-gray-300 bg-white px-6 py-16 text-center">
            <h2 class="text-lg font-semibold text-gray-900">
                Доступных курсов пока нет
            </h2>

            <p class="mt-2 text-sm text-gray-600">
                Опубликованные курсы появятся здесь.
            </p>
        </div>
    @endif
</div>