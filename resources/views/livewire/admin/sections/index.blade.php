<div class="max-w-6xl mx-auto py-6">

<div class="mb-6">

    <a
        href="{{ route('admin.courses.index') }}"
        class="text-blue-600 hover:text-blue-800 font-medium"
    >
        ← К списку курсов
    </a>

    <div class="flex justify-between items-center mt-3">

        <div>

            <h1 class="text-2xl font-bold">
                {{ $course->title }}
            </h1>

            <p class="text-gray-500">
                Разделы курса
            </p>

        </div>

        <a
            href="{{ route('admin.courses.sections.create', $course) }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
        >
            + Добавить раздел
        </a>

    </div>

</div>

    @if($sections->isEmpty())

        <div class="border rounded-lg p-8 text-center bg-white">

            <h2 class="text-lg font-semibold mb-2">
                Пока нет разделов
            </h2>

            <p class="text-gray-500">
                Создайте первый раздел курса.
            </p>

        </div>

    @else

        <table class="w-full border-collapse">

            <thead>

                <tr class="bg-gray-100">

                    <th class="border px-4 py-2 w-20">
                        #
                    </th>

                    <th class="border px-4 py-2 text-left">
                        Название
                    </th>

                    <th class="border px-4 py-2 w-40">
                        Действия
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($sections as $section)

                    <tr>

                        <td class="border px-4 py-2 text-center">
                            {{ $section->position }}
                        </td>

                        <td class="border px-4 py-2">
                            {{ $section->title }}
                        </td>

                        <td class="border px-4 py-2 whitespace-nowrap">

                            <button
                                wire:click="moveUp({{ $section->id }})"
                                class="text-gray-600 hover:text-black mr-2"
                                title="Вверх"
                            >
                                ⬆️
                            </button>

                            <button
                                wire:click="moveDown({{ $section->id }})"
                                class="text-gray-600 hover:text-black mr-4"
                                title="Вниз"
                            >
                                ⬇️
                            </button>

                            <a
                                href="{{ route('admin.sections.edit', $section) }}"
                                class="text-indigo-600 hover:text-indigo-800 font-medium"
                            >
                                ✏️ Изменить
                            </a>

                            <button
                                wire:click="delete({{ $section->id }})"
                                wire:confirm="Удалить раздел «{{ $section->title }}»?"
                                class="text-red-600 hover:text-red-800 font-medium"
                            >
                                🗑️ Удалить
                            </button>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    @endif

</div>