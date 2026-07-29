<div class="py-8">
    <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
        <header>
            <h1 class="text-3xl font-bold text-gray-900">
                Добро пожаловать, {{ $studentName }}!
            </h1>

            <p class="mt-2 text-gray-600">
                Продолжайте обучение и следите за прогрессом своих курсов.
            </p>
        </header>

        <section
            class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm"
            aria-labelledby="continue-learning-heading"
        >
            <div class="border-b border-gray-200 px-6 py-5">
                <h2
                    id="continue-learning-heading"
                    class="text-xl font-semibold text-gray-900"
                >
                    Продолжить обучение
                </h2>
            </div>

            @if ($currentCourse !== null && $nextLesson !== null)
                <div class="space-y-6 px-6 py-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $currentCourse->title }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-600">
                            Прогресс: {{ $progress }}%
                        </p>
                    </div>

                    <div
                        class="h-3 w-full overflow-hidden rounded-full bg-gray-200"
                        role="progressbar"
                        aria-label="Прогресс курса"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        aria-valuenow="{{ $progress }}"
                    >
                        <div
                            class="h-full rounded-full bg-indigo-600 transition-all"
                            style="width: {{ $progress }}%"
                        ></div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">
                            Следующий урок
                        </p>

                        <p class="mt-1 font-medium text-gray-900">
                            {{ $nextLesson->title }}
                        </p>
                    </div>

                    <div>
                        <a
                            href="{{ route('student.lessons.show', $nextLesson) }}"
                            wire:navigate
                            class="inline-flex items-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Продолжить
                        </a>
                    </div>
                </div>
            @else
                <div class="px-6 py-8">
                    <p class="text-gray-600">
                        У вас пока нет активных курсов.
                    </p>

                    <a
                        href="{{ route('student.courses.index') }}"
                        wire:navigate
                        class="mt-4 inline-flex items-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Перейти в каталог
                    </a>
                </div>
            @endif
        </section>

        <section
            class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm"
            aria-labelledby="my-courses-heading"
        >
            <div class="flex items-center justify-between gap-4 border-b border-gray-200 px-6 py-5">
                <h2
                    id="my-courses-heading"
                    class="text-xl font-semibold text-gray-900"
                >
                    Мои курсы
                </h2>

                <a
                    href="{{ route('student.courses.index') }}"
                    wire:navigate
                    class="text-sm font-medium text-indigo-600 transition hover:text-indigo-800"
                >
                    Перейти в каталог
                </a>
            </div>

            @if ($myCourses !== [])
                <div class="grid gap-5 p-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($myCourses as $course)
                        <article
                            wire:key="dashboard-course-{{ $course['id'] }}"
                            class="flex flex-col rounded-xl border border-gray-200 bg-white p-5"
                        >
                            <div class="flex items-start justify-between gap-4">
                                <h3 class="font-semibold text-gray-900">
                                    {{ $course['title'] }}
                                </h3>

                                @if ($course['is_completed'])
                                    <span class="shrink-0 rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                        Завершён
                                    </span>
                                @else
                                    <span class="shrink-0 rounded-full bg-indigo-100 px-2.5 py-1 text-xs font-medium text-indigo-700">
                                        В процессе
                                    </span>
                                @endif
                            </div>

                            <div class="mt-5">
                                <div class="flex items-center justify-between gap-4 text-sm">
                                    <span class="text-gray-600">
                                        Прогресс
                                    </span>

                                    <span class="font-medium text-gray-900">
                                        {{ $course['progress'] }}%
                                    </span>
                                </div>

                                <div
                                    class="mt-2 h-2.5 w-full overflow-hidden rounded-full bg-gray-200"
                                    role="progressbar"
                                    aria-label="Прогресс курса {{ $course['title'] }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                    aria-valuenow="{{ $course['progress'] }}"
                                >
                                    <div
                                        class="h-full rounded-full bg-indigo-600"
                                        style="width: {{ $course['progress'] }}%"
                                    ></div>
                                </div>
                            </div>

                            @if ($course['is_completed'] && $course['completed_at'] !== null)
                                <p class="mt-4 text-sm text-gray-600">
                                    Завершён {{ $course['completed_at'] }}
                                </p>
                            @endif

                            <div class="mt-auto pt-5">
                                <a
                                    href="{{ route('student.courses.show', $course['id']) }}"
                                    wire:navigate
                                    class="inline-flex text-sm font-medium text-indigo-600 transition hover:text-indigo-800"
                                >
                                    {{ $course['is_completed'] ? 'Посмотреть курс' : 'Открыть курс' }}
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="px-6 py-8">
                    <p class="text-gray-600">
                        Вы пока не записаны ни на один курс.
                    </p>

                    <a
                        href="{{ route('student.courses.index') }}"
                        wire:navigate
                        class="mt-4 inline-flex items-center text-sm font-medium text-indigo-600 transition hover:text-indigo-800"
                    >
                        Посмотреть доступные курсы
                    </a>
                </div>
            @endif
        </section>
    </div>
</div>