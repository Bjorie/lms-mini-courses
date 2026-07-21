<div class="max-w-2xl mx-auto py-6">

    <h1 class="text-2xl font-bold mb-6">
        Редактировать раздел
    </h1>

    <form wire:submit="save" class="space-y-6">

        <div>

            <x-input-label
                for="title"
                value="Название раздела"
            />

            <x-text-input
                id="title"
                wire:model.blur="title"
                class="mt-1 block w-full"
            />

            <x-input-error
                :messages="$errors->get('title')"
                class="mt-2"
            />

        </div>

        <div class="flex gap-3">

            <x-primary-button>
                Сохранить изменения
            </x-primary-button>

            <a
                href="{{ route('admin.courses.sections.index', $section->course) }}"
                class="px-4 py-2 border rounded"
            >
                Отмена
            </a>

        </div>

    </form>

</div>