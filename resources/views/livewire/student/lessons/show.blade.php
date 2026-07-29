<div class="mx-auto max-w-4xl px-4 py-8">
    <div class="mb-6">
        <a
            href="{{ route('student.courses.show', $lesson->section->course) }}"
            wire:navigate
            class="text-sm font-medium text-gray-600 transition hover:text-gray-900"
        >
            ← Вернуться к курсу
        </a>
    </div>

    <article class="rounded-xl bg-white p-6 shadow-sm">
        <div class="mb-2 text-sm text-gray-500">
            {{ $lesson->section->title }}
        </div>

        <h1 class="text-3xl font-bold text-gray-900">
            {{ $lesson->title }}
        </h1>

        <div class="mt-6 border-y border-gray-200 py-5">
            <div class="flex items-center justify-between gap-4 text-sm">
                <span class="font-medium text-gray-700">
                    Прогресс курса
                </span>

                <span class="font-semibold text-gray-900">
                    {{ $progressPercentage }}%
                </span>
            </div>

            <div
                class="mt-2 h-3 overflow-hidden rounded-full bg-gray-200"
                role="progressbar"
                aria-label="Прогресс курса"
                aria-valuemin="0"
                aria-valuemax="100"
                aria-valuenow="{{ $progressPercentage }}"
            >
                <div
                    class="h-full rounded-full bg-green-600 transition-all duration-300"
                    style="width: {{ $progressPercentage }}%"
                ></div>
            </div>
        </div>

        <div class="prose mt-8 max-w-none">
            {!! $lesson->content !!}
        </div>
    </article>

    <div class="mt-6">
        @if (session('success'))
            <div class="mb-4 rounded-lg border border-green-300 bg-green-100 px-4 py-3 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($isCompleted)
            @if ($nextLesson)
                <div class="rounded-xl border border-green-300 bg-green-50 p-5">
                    <p class="font-medium text-green-800">
                        ✓ Урок завершён
                    </p>

                    <p class="mt-1 text-sm text-green-700">
                        Можно переходить к следующему уроку.
                    </p>

                    <a
                        href="{{ route('student.lessons.show', $nextLesson) }}"
                        wire:navigate
                        class="mt-4 inline-flex items-center rounded-lg bg-blue-600 px-5 py-3 font-medium text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        Следующий урок →
                    </a>
                </div>
            @else
                <div class="rounded-xl border border-green-300 bg-green-50 p-5 text-green-800">
                    <p class="text-lg font-semibold">
                        🎉 Поздравляем!
                    </p>

                    <p class="mt-1">
                        Вы завершили все уроки курса.
                    </p>

                    <a
                        href="{{ route('student.courses.show', $lesson->section->course) }}"
                        wire:navigate
                        class="mt-4 inline-flex items-center rounded-lg bg-green-600 px-5 py-3 font-medium text-white transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                    >
                        Вернуться к курсу
                    </a>
                </div>
            @endif
        @else
            <button
                type="button"
                wire:click="complete"
                wire:loading.attr="disabled"
                wire:target="complete"
                class="inline-flex items-center rounded-lg bg-green-600 px-5 py-3 font-medium text-white transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
            >
                <span wire:loading.remove wire:target="complete">
                    Отметить урок завершённым
                </span>

                <span wire:loading wire:target="complete">
                    Сохранение...
                </span>
            </button>
        @endif
    </div>

    <nav
        class="mt-8 flex flex-col gap-4 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-between"
        aria-label="Навигация по урокам"
    >
        <div>
            @if ($previousLesson)
                <a
                    href="{{ route('student.lessons.show', $previousLesson) }}"
                    wire:navigate
                    class="inline-flex min-w-48 items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3 font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
                >
                    ← Предыдущий урок
                </a>
            @endif
        </div>

        <div class="sm:text-right">
            @if ($nextLesson)
                <a
                    href="{{ route('student.lessons.show', $nextLesson) }}"
                    wire:navigate
                    class="inline-flex min-w-48 items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3 font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
                >
                    Следующий урок →
                </a>
            @elseif (! $isCompleted)
                <span class="text-sm font-medium text-gray-600">
                    Это последний урок курса
                </span>
            @endif
        </div>
    </nav>
</div>