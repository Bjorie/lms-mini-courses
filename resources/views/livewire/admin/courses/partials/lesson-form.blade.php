{{-- resources/views/livewire/admin/courses/partials/lesson-form.blade.php --}}

<form
    wire:submit.prevent="{{ $editingLesson ? 'updateLesson' : 'saveLesson' }}"
    class="space-y-6"
>
    <div class="border-b border-gray-200 pb-4">
        <h3 class="text-lg font-semibold text-gray-900">
            {{ $editingLesson ? 'Редактирование урока' : 'Новый урок' }}
        </h3>

        <p class="mt-1 text-sm text-gray-500">
            Заполните информацию об уроке.
        </p>
    </div>

    <div class="grid gap-6 md:grid-cols-2">

        {{-- Название --}}
        <div class="md:col-span-2">
            <x-input-label
                for="lesson-title"
                value="Название урока"
            />

            <x-text-input
                id="lesson-title"
                class="mt-1 block w-full"
                wire:model.blur="lessonForm.title"
            />

            <x-input-error
                class="mt-2"
                :messages="$errors->get('lessonForm.title')"
            />
        </div>

        {{-- Slug --}}
        <div class="md:col-span-2">
            <x-input-label
                for="lesson-slug"
                value="Slug"
            />

            <x-text-input
                id="lesson-slug"
                class="mt-1 block w-full"
                wire:model.blur="lessonForm.slug"
            />

            <x-input-error
                class="mt-2"
                :messages="$errors->get('lessonForm.slug')"
            />
        </div>

        {{-- Тип урока --}}
        <div>
            <x-input-label
                for="lesson-type"
                value="Тип урока"
            />

            <select
                id="lesson-type"
                wire:model.blur="lessonForm.type"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
                <option value="video">Видео</option>
                <option value="text">Текст</option>
                <option value="quiz">Тест</option>
                <option value="file">Файл</option>
            </select>

            <x-input-error
                class="mt-2"
                :messages="$errors->get('lessonForm.type')"
            />
        </div>

        {{-- Продолжительность --}}
        <div>
            <x-input-label
                for="lesson-duration"
                value="Продолжительность (мин.)"
            />

            <x-text-input
                id="lesson-duration"
                type="number"
                min="1"
                class="mt-1 block w-full"
                wire:model.blur="lessonForm.duration"
            />

            <x-input-error
                class="mt-2"
                :messages="$errors->get('lessonForm.duration')"
            />
        </div>

        {{-- Порядок --}}
        <div>
            <x-input-label
                for="lesson-position"
                value="Порядок"
            />

            <x-text-input
                id="lesson-position"
                type="number"
                min="1"
                class="mt-1 block w-full"
                wire:model.blur="lessonForm.position"
            />

            <x-input-error
                class="mt-2"
                :messages="$errors->get('lessonForm.position')"
            />
        </div>

        {{-- Видео --}}
        <div>
            <x-input-label
                for="lesson-video"
                value="Ссылка на видео"
            />

            <x-text-input
                id="lesson-video"
                type="url"
                class="mt-1 block w-full"
                wire:model.blur="lessonForm.video_url"
                placeholder="https://..."
            />

            <x-input-error
                class="mt-2"
                :messages="$errors->get('lessonForm.video_url')"
            />
        </div>

        {{-- Контент --}}
        <div class="md:col-span-2">
            <x-input-label
                for="lesson-content"
                value="Текст урока"
            />

            <textarea
                id="lesson-content"
                rows="8"
                wire:model.blur="lessonForm.content"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            ></textarea>

            <x-input-error
                class="mt-2"
                :messages="$errors->get('lessonForm.content')"
            />
        </div>

    </div>

    <div class="grid gap-4 md:grid-cols-2">

        <label class="flex items-center gap-3">
            <input
                type="checkbox"
                wire:model="lessonForm.is_free"
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
            >

            <span class="text-sm text-gray-700">
                Бесплатный урок
            </span>
        </label>

        <label class="flex items-center gap-3">
            <input
                type="checkbox"
                wire:model="lessonForm.isPublished"
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
            >

            <span class="text-sm text-gray-700">
                Опубликовать урок
            </span>
        </label>

    </div>

    <div class="flex items-center justify-end gap-3 border-t border-gray-200 pt-5">

        <x-secondary-button
            type="button"
            wire:click="cancelLesson"
        >
            Отмена
        </x-secondary-button>

        <x-primary-button type="submit">

            @if ($editingLesson)
                Сохранить изменения
            @else
                Создать урок
            @endif

        </x-primary-button>

    </div>
</form>