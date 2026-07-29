<div class="max-w-5xl mx-auto py-6">

    <x-admin.back-link
        :href="route('admin.courses.builder', $section->course)"
    >
        Вернуться в конструктор курса
    </x-admin.back-link>

    <div class="mt-6">
        <h1 class="text-3xl font-bold">
            Новый урок
        </h1>

        <p class="mt-2 text-gray-500">
            Раздел: {{ $section->title }}
        </p>
    </div>

    <form
        wire:submit="save"
        class="mt-8 space-y-8"
    >
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b px-6 py-4">
                <h2 class="text-lg font-semibold">
                    Основная информация
                </h2>
            </div>

            <div class="space-y-6 p-6">

                <div>
                    <x-input-label
                        for="title"
                        value="Название урока"
                    />

                    <x-text-input
                        id="title"
                        wire:model.live="form.title"
                        class="mt-1 block w-full"
                    />

                    <x-input-error
                        :messages="$errors->get('form.title')"
                        class="mt-2"
                    />
                </div>

                <div>
                    <x-input-label
                        for="slug"
                        value="Slug"
                    />

                    <x-text-input
                        id="slug"
                        wire:model.blur="form.slug"
                        class="mt-1 block w-full"
                    />

                    <x-input-error
                        :messages="$errors->get('form.slug')"
                        class="mt-2"
                    />
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <div>
                        <x-input-label
                            for="video_url"
                            value="Ссылка на видео"
                        />

                        <x-text-input
                            id="video_url"
                            wire:model.live="form.video_url"
                            class="mt-1 block w-full"
                        />

                        <x-input-error
                            :messages="$errors->get('form.video_url')"
                            class="mt-2"
                        />
                    </div>

                    <div>
                        <x-input-label
                            for="duration"
                            value="Продолжительность (сек.)"
                        />

                        <x-text-input
                            id="duration"
                            type="number"
                            min="0"
                            wire:model.live="form.duration"
                            class="mt-1 block w-full"
                        />

                        <x-input-error
                            :messages="$errors->get('form.duration')"
                            class="mt-2"
                        />
                    </div>

                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b px-6 py-4">
                <h2 class="text-lg font-semibold">
                    Настройки
                </h2>
            </div>

            <div class="space-y-5 p-6">

                <label class="flex items-center gap-3">
                    <input
                        type="checkbox"
                        wire:model.live="form.is_free"
                        class="rounded border-gray-300"
                    >

                    <span>Бесплатный урок</span>
                </label>

                <label class="flex items-center gap-3">
                    <input
                        type="checkbox"
                        wire:model.live="form.is_published"
                        class="rounded border-gray-300"
                    >

                    <span>Опубликован</span>
                </label>

            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b px-6 py-4">
                <h2 class="text-lg font-semibold">
                    Контент урока
                </h2>
            </div>

            <div class="p-6">
                <x-input-label
                    for="lesson-editor"
                    value="Содержимое урока"
                />

                <div
                    id="lesson-editor"
                    class="mt-2 min-h-[350px] rounded-lg border border-gray-300 bg-white"
                    wire:ignore
                ></div>
            </div>
        </div>

        <div class="flex items-center gap-4">

            <x-primary-button
                type="submit"
                wire:loading.attr="disabled"
            >
                Создать урок
            </x-primary-button>

            <a
                href="{{ route('admin.courses.builder', $section->course) }}"
                class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
            >
                Отмена
            </a>
        </div>

        <div
            wire:loading
            wire:target="save"
            class="text-sm text-gray-500"
        >
            Сохранение...
        </div>
    </form>
</div>

@script
<script>
document.addEventListener('livewire:navigated', () => {
    const editorElement =
        document.getElementById('lesson-editor');

    if (!editorElement || editorElement.editor) {
        return;
    }

    editorElement.editor = window.initTiptap(
        editorElement,
        @js($form->content ?? ''),
        (html) => {
            $wire.set('form.content', html);
        }
    );
});
</script>
@endscript