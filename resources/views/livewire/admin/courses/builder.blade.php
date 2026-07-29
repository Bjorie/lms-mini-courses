<div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">

    @if (session()->has('success'))
        <div
            class="mb-6 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-green-800"
            role="alert"
        >
            {{ session('success') }}
        </div>
    @endif

    <x-admin.back-link :href="route('admin.courses.index')">
        К списку курсов
    </x-admin.back-link>

    {{-- Информация о курсе --}}
    <div class="mb-8 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-200 px-6 py-5">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="mb-1 text-sm font-medium text-blue-600">
                        Конструктор курса
                    </p>

                    <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                        {{ $course->title }}
                    </h1>

                    @if ($course->category)
                        <p class="mt-2 text-sm text-gray-500">
                            Категория: {{ $course->category->name }}
                        </p>
                    @endif
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    @if ($course->published_at)
                        <span class="rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-700">
                            Опубликован
                        </span>
                    @else
                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-sm font-medium text-yellow-700">
                            Черновик
                        </span>
                    @endif

                    <a
                        href="{{ route('admin.courses.edit', $course) }}"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                    >
                        Редактировать курс
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 divide-x divide-y divide-gray-200 sm:grid-cols-4 sm:divide-y-0">
            <div class="px-5 py-4">
                <p class="text-sm text-gray-500">
                    Разделов
                </p>

                <p class="mt-1 text-xl font-semibold text-gray-900">
                    {{ $course->sections->count() }}
                </p>
            </div>

            <div class="px-5 py-4">
                <p class="text-sm text-gray-500">
                    Уроков
                </p>

                <p class="mt-1 text-xl font-semibold text-gray-900">
                    {{ $course->sections->sum(fn ($section) => $section->lessons->count()) }}
                </p>
            </div>

            <div class="px-5 py-4">
                <p class="text-sm text-gray-500">
                    Бесплатных уроков
                </p>

                <p class="mt-1 text-xl font-semibold text-gray-900">
                    {{ $course->sections->sum(
                        fn ($section) => $section->lessons->where('is_free', true)->count()
                    ) }}
                </p>
            </div>

            <div class="px-5 py-4">
                <p class="text-sm text-gray-500">
                    Цена
                </p>

                <p class="mt-1 text-xl font-semibold text-gray-900">
                    @if ((float) $course->price > 0)
                        {{ number_format((float) $course->price, 2, ',', ' ') }} ₽
                    @else
                        Бесплатно
                    @endif
                </p>
            </div>
        </div>
    </div>

    {{-- Разделы и уроки --}}
    <div class="space-y-6">
        @forelse ($course->sections as $section)
            <section
                wire:key="section-{{ $section->id }}"
                class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm"
            >
                <header class="flex flex-col gap-3 border-b border-gray-200 bg-gray-50 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-700">
                                {{ $section->position }}
                            </span>

                            <h2 class="text-lg font-semibold text-gray-900">
                                {{ $section->title }}
                            </h2>
                        </div>

                        <p class="mt-2 pl-11 text-sm text-gray-500">
                            {{ $section->lessons->count() }}
                            {{ trans_choice('урок|урока|уроков', $section->lessons->count()) }}
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <button
                            type="button"
                            wire:click="editSection({{ $section->id }})"
                            wire:loading.attr="disabled"
                            wire:target="editSection({{ $section->id }})"
                            class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            Редактировать
                        </button>

                        <button
                            type="button"
                            wire:click="showLessonForm({{ $section->id }})"
                            wire:loading.attr="disabled"
                            wire:target="showLessonForm({{ $section->id }})"
                            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            Добавить урок
                        </button>

                        <button
                            type="button"
                            wire:click="deleteSection({{ $section->id }})"
                            wire:confirm="Удалить раздел «{{ $section->title }}» вместе со всеми его уроками?"
                            wire:loading.attr="disabled"
                            wire:target="deleteSection({{ $section->id }})"
                            class="rounded-lg border border-red-200 bg-white px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            Удалить
                        </button>
                    </div>
                </header>

                @if ($editingSection === $section->id)
                    <div class="border-b border-gray-200 bg-blue-50 px-6 py-5">
                        @include('livewire.admin.courses.partials.section-form')
                    </div>
                @endif

                <div class="divide-y divide-gray-100">
                    @forelse ($section->lessons as $lesson)
                        <article
                            wire:key="lesson-{{ $lesson->id }}"
                            class="px-6 py-4 transition hover:bg-gray-50"
                        >
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="min-w-0">
                                    <div class="flex items-start gap-3">
                                        <span class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded bg-gray-100 text-xs font-semibold text-gray-600">
                                            {{ $lesson->position }}
                                        </span>

                                        <div class="min-w-0">
                                            <h3 class="font-medium text-gray-900">
                                                {{ $lesson->title }}
                                            </h3>

                                            <div class="mt-2 flex flex-wrap items-center gap-2">
                                                <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700">
                                                    {{ match ($lesson->type) {
                                                        'video' => 'Видео',
                                                        'text' => 'Текст',
                                                        'quiz' => 'Тест',
                                                        'file' => 'Файл',
                                                        default => ucfirst($lesson->type),
                                                    } }}
                                                </span>

                                                @if ($lesson->is_free)
                                                    <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                                        Бесплатный
                                                    </span>
                                                @endif

                                                @if ($lesson->published_at)
                                                    <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-700">
                                                        Опубликован
                                                    </span>
                                                @else
                                                    <span class="rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-700">
                                                        Черновик
                                                    </span>
                                                @endif

                                                @if ($lesson->duration)
                                                    <span class="text-xs text-gray-500">
                                                        {{ $lesson->duration }} мин.
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex shrink-0 items-center gap-2">
                                    <button
                                        type="button"
                                        wire:click="editLesson({{ $lesson->id }})"
                                        wire:loading.attr="disabled"
                                        wire:target="editLesson({{ $lesson->id }})"
                                        class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-50"
                                    >
                                        Редактировать
                                    </button>

                                    <button
                                        type="button"
                                        wire:click="deleteLesson({{ $lesson->id }})"
                                        wire:confirm="Удалить урок «{{ $lesson->title }}»?"
                                        wire:loading.attr="disabled"
                                        wire:target="deleteLesson({{ $lesson->id }})"
                                        class="rounded-lg border border-red-200 bg-white px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-50"
                                    >
                                        Удалить
                                    </button>
                                </div>
                            </div>

                            @if ($editingLesson === $lesson->id)
                                <div class="mt-5 border-t border-gray-200 pt-5">
                                    @include('livewire.admin.courses.partials.lesson-form')
                                </div>
                            @endif
                        </article>
                    @empty
                        <div class="px-6 py-8 text-center">
                            <p class="text-sm text-gray-500">
                                В этом разделе пока нет уроков.
                            </p>

                            <button
                                type="button"
                                wire:click="showLessonForm({{ $section->id }})"
                                class="mt-3 text-sm font-medium text-blue-600 hover:text-blue-800"
                            >
                                Создать первый урок
                            </button>
                        </div>
                    @endforelse
                </div>

                @if (
                    $addingToSection === $section->id
                    && $editingLesson === null
                )
                    <div class="border-t border-gray-200 bg-gray-50 px-6 py-5">
                        @include('livewire.admin.courses.partials.lesson-form')
                    </div>
                @endif
            </section>
        @empty
            <div class="rounded-xl border-2 border-dashed border-gray-300 bg-white px-6 py-12 text-center">
                <h2 class="text-lg font-semibold text-gray-900">
                    В курсе пока нет разделов
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Сначала создайте первый раздел, а затем добавьте в него уроки.
                </p>

                @if ($showSectionForm && $editingSection === null)
                    <div class="mx-auto mt-6 max-w-3xl rounded-xl border border-gray-200 bg-gray-50 p-6 text-left">
                        @include('livewire.admin.courses.partials.section-form')
                    </div>
                @else
                    <button
                        type="button"
                        wire:click="showSectionForm"
                        wire:loading.attr="disabled"
                        wire:target="showSectionForm"
                        class="mt-5 inline-flex rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        Создать раздел
                    </button>
                @endif
            </div>
        @endforelse
    </div>

    @if ($course->sections->isNotEmpty())
        @if ($showSectionForm && $editingSection === null)
            <div class="mt-8 rounded-xl border border-gray-200 bg-white px-6 py-5 shadow-sm">
                @include('livewire.admin.courses.partials.section-form')
            </div>
        @else
            <div class="mt-8 flex justify-center">
                <button
                    type="button"
                    wire:click="showSectionForm"
                    wire:loading.attr="disabled"
                    wire:target="showSectionForm"
                    class="inline-flex items-center rounded-lg border border-dashed border-gray-400 bg-white px-5 py-3 text-sm font-medium text-gray-700 transition hover:border-blue-500 hover:text-blue-600 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    Добавить раздел
                </button>
            </div>
        @endif
    @endif

</div>