<div class="max-w-xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">
        Создать категорию
    </h1>

    <form wire:submit="save" class="space-y-4">

        <div>
            <label class="block mb-2 font-medium">
                Название категории
            </label>

            <input
                type="text"
                wire:model="name"
                class="w-full border rounded px-3 py-2"
            >

            @error('name')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <button
            type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded"
        >
            Создать
        </button>

    </form>

</div>