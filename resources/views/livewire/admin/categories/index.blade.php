@if (session()->has('success'))

    <div class="mb-4 rounded bg-green-100 border border-green-400 text-green-700 px-4 py-3">

        {{ session('success') }}

    </div>

@endif


<div class="p-6">

    <h1 class="text-2xl font-bold mb-4">
        Категории курсов
    </h1>

    <table class="min-w-full border border-gray-300">

        <thead class="bg-gray-100">

            <tr>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Название</th>
                <th class="border px-4 py-2">Slug</th>
                <th class="border px-4 py-2 w-40">Действия</th>
            </tr>

        </thead>

        <tbody>

        @forelse($categories as $category)

            <tr>

                <td class="border px-4 py-2">
                    {{ $category->id }}
                </td>

                <td class="border px-4 py-2">
                    {{ $category->name }}
                </td>

                <td class="border px-4 py-2">
                    {{ $category->slug }}
                </td>

                <td class="border px-4 py-2">

                    <div class="flex gap-2 justify-center">

                        <a
                            href="{{ route('admin.categories.edit', $category) }}"
                            class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
                        >
                            ✏️
                        </a>

                        <button

                            onclick="confirm('Удалить категорию?') || event.stopImmediatePropagation()"

                            wire:click="delete({{ $category->id }})"

                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"

                        >
                            🗑️
                        </button>

                    </div>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="3" class="text-center py-6">
                    Категории отсутствуют.
                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>