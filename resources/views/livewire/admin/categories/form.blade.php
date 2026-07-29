<form
    wire:submit="save"
    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8"
>
    <div>
        <label
            for="category-name"
            class="block text-sm font-semibold text-gray-700"
        >
            Название категории
        </label>

        <input
            id="category-name"
            type="text"
            wire:model="name"
            placeholder="Например: PHP"
            autocomplete="off"
            autofocus
            class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm transition focus:border-blue-500 focus:ring-blue-500"
        >

        @error('name')
            <p class="mt-2 text-sm font-medium text-red-600">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
        <a
            href="{{ route('admin.categories.index') }}"
            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
        >
            Отмена
        </a>

        <button
            type="submit"
            wire:loading.attr="disabled"
            wire:target="save"
            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
        >
            <span wire:loading.remove wire:target="save">
                {{ $submitLabel }}
            </span>

            <span wire:loading wire:target="save">
                Сохранение...
            </span>
        </button>
    </div>
</form>