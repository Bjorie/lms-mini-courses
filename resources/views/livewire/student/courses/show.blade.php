<div class="mx-auto max-w-6xl px-4 py-8">
    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-300 bg-green-100 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if (session('warning'))
        <div class="mb-6 rounded-lg border border-yellow-300 bg-yellow-100 px-4 py-3 text-yellow-800">
            {{ session('warning') }}
        </div>
    @endif

    <div class="rounded-xl bg-white p-6 shadow-sm">
        <h1 class="text-4xl font-bold text-gray-900">
            {{ $course->title }}
        </h1>

        @if ($course->short_description)
            <p class="mt-3 text-gray-600">
                {{ $course->short_description }}
            </p>
        @endif

        <div class="mt-6 space-y-2 text-gray-700">
            <div>
                <strong>Автор:</strong>
                {{ $course->author?->name ?? 'Не указан' }}
            </div>

            @if ($course->category)
                <div>
                    <strong>Категория:</strong>
                    {{ $course->category->name }}
                </div>
            @endif

            <div>
                <strong>Разделов:</strong>
                {{ $course->sections->count() }}
            </div>

            <div>
                <strong>Уроков:</strong>
                {{ $totalLessons }}
            </div>
        </div>

        <div class="mt-8">
            @if ($isEnrolled)
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3">
                    <p class="font-medium text-green-800">
                        Вы записаны на курс.
                    </p>

                    <p class="mt-1 text-sm text-green-700">
                        Продолжайте обучение с текущего урока.
                    </p>
                </div>

                <div class="mb-6">
                    <div class="mb-2 flex items-center justify-between gap-4 text-sm">
                        <span class="font-medium text-gray-700">
                            Прогресс курса
                        </span>

                        <span class="font-semibold text-gray-900">
                            {{ $progressPercentage }}%
                        </span>
                    </div>

                    <div
                        class="h-3 overflow-hidden rounded-full bg-gray-200"
                        role="progressbar"
                        aria-label="Прогресс курса"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        aria-valuenow="{{ $progressPercentage }}"
                    >
                        <div
                            class="h-full rounded-full bg-green-600 transition-all"
                            style="width: {{ $progressPercentage }}%"
                        ></div>
                    </div>

                    <p class="mt-2 text-sm text-gray-600">
                        Завершено уроков:
                        <span class="font-medium text-gray-900">
                            {{ $completedLessonsCount }}
                            из
                            {{ $totalLessons }}
                        </span>
                    </p>
                </div>

                @if ($nextLesson)
                    <a
                        href="{{ route('student.lessons.show', $nextLesson) }}"
                        wire:navigate
                        class="inline-flex items-center rounded-lg bg-green-600 px-5 py-3 font-medium text-white transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                    >
                        Перейти к обучению
                    </a>
                @elseif ($totalLessons > 0)
                    <div class="rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-green-800">
                        Поздравляем! Вы завершили все уроки курса.
                    </div>
                @else
                    <div class="rounded-lg border border-yellow-300 bg-yellow-100 px-4 py-3 text-yellow-800">
                        В этом курсе пока нет уроков.
                    </div>
                @endif
            @else
                <button
                    type="button"
                    wire:click="enroll"
                    wire:loading.attr="disabled"
                    wire:target="enroll"
                    class="inline-flex items-center rounded-lg bg-blue-600 px-5 py-3 font-medium text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="enroll">
                        Записаться на курс
                    </span>

                    <span wire:loading wire:target="enroll">
                        Запись...
                    </span>
                </button>
            @endif
        </div>
    </div>

    <div class="mt-8">
        <h2 class="mb-5 text-2xl font-bold text-gray-900">
            Программа курса
        </h2>

        <div class="space-y-6">
            @forelse ($course->sections as $section)
                <section class="rounded-xl border border-gray-200 bg-white p-5">
                    <h3 class="text-xl font-semibold text-gray-900">
                        {{ $section->title }}
                    </h3>

                    @if ($section->lessons->isNotEmpty())
                        <div class="mt-4 space-y-2">
                            @foreach ($section->lessons as $lesson)
                                @php
                                    $isCompleted = in_array(
                                        $lesson->id,
                                        $completedLessonIds,
                                        true,
                                    );

                                    $isNext = $nextLesson?->id === $lesson->id;
                                @endphp

                                @if ($isEnrolled)
                                    <a
                                        href="{{ route('student.lessons.show', $lesson) }}"
                                        wire:navigate
                                        @class([
                                            'flex items-center justify-between gap-4 rounded-lg border px-4 py-3 transition',
                                            'border-green-200 bg-green-50 hover:bg-green-100' => $isCompleted,
                                            'border-blue-300 bg-blue-50 hover:bg-blue-100' => $isNext,
                                            'border-gray-200 text-gray-800 hover:bg-gray-50' => ! $isCompleted && ! $isNext,
                                        ])
                                    >
                                        <span class="flex items-center gap-3">
                                            @if ($isCompleted)
                                                <span
                                                    class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-green-100 text-sm font-bold text-green-700"
                                                    aria-hidden="true"
                                                >
                                                    ✓
                                                </span>
                                            @elseif ($isNext)
                                                <span
                                                    class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs text-blue-700"
                                                    aria-hidden="true"
                                                >
                                                    ▶
                                                </span>
                                            @else
                                                <span
                                                    class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border border-gray-300 text-sm text-gray-400"
                                                    aria-hidden="true"
                                                >
                                                    ○
                                                </span>
                                            @endif

                                            <span
                                                @class([
                                                    'font-medium' => $isCompleted || $isNext,
                                                    'text-green-900' => $isCompleted,
                                                    'text-blue-900' => $isNext,
                                                ])
                                            >
                                                {{ $lesson->title }}
                                            </span>
                                        </span>

                                        <span class="shrink-0 text-sm">
                                            @if ($isCompleted)
                                                <span class="text-green-700">
                                                    Завершён
                                                </span>
                                            @elseif ($isNext)
                                                <span class="font-medium text-blue-700">
                                                    Следующий
                                                </span>
                                            @else
                                                <span class="text-gray-500">
                                                    Не начат
                                                </span>
                                            @endif
                                        </span>
                                    </a>
                                @else
                                    <div class="flex items-center justify-between gap-4 rounded-lg border border-gray-200 px-4 py-3 text-gray-500">
                                        <span class="flex items-center gap-3">
                                            <span
                                                class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border border-gray-300 text-sm text-gray-400"
                                                aria-hidden="true"
                                            >
                                                ○
                                            </span>

                                            <span>
                                                {{ $lesson->title }}
                                            </span>
                                        </span>

                                        <span class="shrink-0 text-sm">
                                            Закрыто
                                        </span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="mt-3 text-sm text-gray-500">
                            В этом разделе пока нет уроков.
                        </p>
                    @endif
                </section>
            @empty
                <div class="rounded-lg border border-yellow-300 bg-yellow-50 px-4 py-3 text-yellow-800">
                    В курсе пока нет разделов.
                </div>
            @endforelse
        </div>
    </div>
</div>