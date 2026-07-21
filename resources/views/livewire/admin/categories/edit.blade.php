<div class="max-w-xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">
        Редактирование категории
    </h1>

    <form wire:submit="save">

        <div class="mb-4">

            <label class="block mb-2">
                Название
            </label>

            <input
                type="text"
                wire:model="name"
                class="w-full border rounded px-3 py-2"
            >

            @error('name')
                <p class="text-red-600 text-sm">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded"
        >
            Сохранить
        </button>

    </form>

</div>
