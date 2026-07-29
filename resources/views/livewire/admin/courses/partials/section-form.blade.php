<form
    wire:submit.prevent="{{ $editingSection ? 'updateSection' : 'saveSection' }}"
    class="space-y-5"
>
    <div class="border-b border-gray-200 pb-4">
        <h3 class="text-lg font-semibold text-gray-900">
            {{ $editingSection ? 'Редактирование раздела' : 'Новый раздел' }}
        </h3>

        <p class="mt-1 text-sm text-gray-500">
            Укажите название раздела и его позицию в курсе.
        </p>
    </div>

    <div class="grid gap-5 md:grid-cols-3">
        {{-- Название --}}
        <div class="md:col-span-2">
            <x-input-label
                for="section-title"
                value="Название раздела"
            />

            <x-text-input
                id="section-title"
                type="text"
                class="mt-1 block w-full"
                wire:model.blur="sectionForm.title"
                placeholder="Например: Введение в Laravel"
                autofocus
            />

            <x-input-error
                class="mt-2"
                :messages="$errors->get('sectionForm.title')"
            />
        </div>

        {{-- Позиция --}}
        <div>
            <x-input-label
                for="section-position"
                value="Порядок"
            />

            <x-text-input
                id="section-position"
                type="number"
                min="1"
                class="mt-1 block w-full"
                wire:model.blur="sectionForm.position"
            />

            <x-input-error
                class="mt-2"
                :messages="$errors->get('sectionForm.position')"
            />
        </div>
    </div>

    <div class="flex flex-col-reverse gap-3 border-t border-gray-200 pt-5 sm:flex-row sm:justify-end">
        <x-secondary-button
            type="button"
            wire:click="cancelSection"
            wire:loading.attr="disabled"
            wire:target="cancelSection,saveSection,updateSection"
        >
            Отмена
        </x-secondary-button>

        <x-primary-button
            type="submit"
            wire:loading.attr="disabled"
            wire:target="saveSection,updateSection"
        >
            <span wire:loading.remove wire:target="saveSection,updateSection">
                {{ $editingSection ? 'Сохранить изменения' : 'Создать раздел' }}
            </span>

            <span wire:loading wire:target="saveSection,updateSection">
                Сохранение...
            </span>
        </x-primary-button>
    </div>
</form>