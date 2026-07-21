<div class="max-w-6xl mx-auto py-6">

    @if(session()->has('success'))
        <div class="mb-4 rounded-lg border border-green-300 bg-green-100 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <x-admin.back-link :href="route('admin.courses.index')">
        К списку курсов
    </x-admin.back-link>

    <div class="mb-8">
        <h1 class="text-3xl font-bold">
            {{ $course->title }}
        </h1>

        <p class="mt-2 text-gray-500">
            Конструктор курса
        </p>
    </div>

    @forelse($course->sections as $section)

        <div class="mb-6 rounded-lg border border-gray-200 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b px-6 py-4">

                <h2 class="text-lg font-semibold">
                    📁 {{ $section->position }}. {{ $section->title }}
                </h2>

            </div>

            <div class="p-6">

                @forelse($section->lessons as $lesson)

                    <div class="flex items-center justify-between border-b py-2 last:border-0">

                        <div class="flex items-center gap-2">

                            <span>
                                📖 {{ $lesson->title }}
                            </span>

                            @if($lesson->is_free)
                                <span class="rounded bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700">
                                    Бесплатно
                                </span>
                            @endif

                            @if($lesson->video_url)
                                <span class="rounded bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700">
                                    🎥 Видео
                                </span>
                            @endif

                            @if($lesson->duration)
                                <span class="rounded bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700">
                                    ⏱ {{ gmdate('i:s', $lesson->duration) }}
                                </span>
                            @endif

                        </div>

                        <div class="flex items-center gap-3">

                            <a
                                href="{{ route('admin.lessons.edit', $lesson) }}"
                                class="text-indigo-600 hover:text-indigo-800"
                                title="Редактировать"
                            >
                                ✏️
                            </a>

                            <button
                                wire:click="deleteLesson({{ $lesson->id }})"
                                class="text-red-600 hover:text-red-800"
                                title="Удалить"
                            >
                                🗑️
                            </button>

                        </div>

                    </div>

                @empty

                    <p class="mb-4 text-gray-500">
                        Пока нет уроков.
                    </p>

                @endforelse

                <button
                    wire:click="showLessonForm({{ $section->id }})"
                    class="mt-4 rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                >
                    + Добавить урок
                </button>

                @if($addingToSection === $section->id)

                    @include('livewire.admin.courses.partials.lesson-form')

                @endif

            </div>

        </div>

    @empty

        <div class="rounded-lg border border-dashed p-10 text-center text-gray-500">

            В этом курсе пока нет разделов.

        </div>

    @endforelse

</div>