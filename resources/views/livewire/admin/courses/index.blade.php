<div class="p-6">

    @if(session()->has('success'))
        <div class="mb-4 rounded-lg border border-green-300 bg-green-100 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">

        <h1 class="text-2xl font-bold">
            Курсы
        </h1>

        <a
            href="{{ route('admin.courses.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded"
        >
            + Добавить курс
        </a>

    </div>

    <table class="min-w-full border border-gray-300">

        <thead class="bg-gray-100">

        <tr>
            <th class="border px-4 py-2">ID</th>
            <th class="border px-4 py-2">Название</th>
            <th class="border px-4 py-2">Категория</th>
            <th class="border px-4 py-2">Автор</th>
            <th class="border px-4 py-2">Цена</th>
            <th class="border px-4 py-2">Статус</th>
            <th class="px-4 py-2 text-left">Действия</th>
        </tr>

        </thead>

        <tbody>

        @forelse($courses as $course)

            <tr>

                <td class="border px-4 py-2">
                    {{ $course->id }}
                </td>

                <td class="border px-4 py-2">
                    {{ $course->title }}
                </td>

                <td class="border px-4 py-2">
                    {{ $course->category?->name ?? '—' }}
                </td>

                <td class="border px-4 py-2">
                    {{ $course->author?->name ?? '—' }}
                </td>

                <td class="border px-4 py-2 text-right">
                    {{ number_format($course->price, 2) }} €
                </td>

                <td class="border px-4 py-2">

<span
    @class([
        'px-2 py-1 rounded text-xs font-semibold',
        'bg-gray-100 text-gray-800' => $course->status->value === 'draft',
        'bg-yellow-100 text-yellow-800' => $course->status->value === 'review',
        'bg-green-100 text-green-800' => $course->status->value === 'published',
        'bg-red-100 text-red-800' => $course->status->value === 'archived',
    ])
>
    {{ $course->status->label() }}
</span>
                </td>

                <td class="border px-4 py-2 whitespace-nowrap">


                    <a
                        href="{{ route('admin.courses.builder', $course) }}"
                        class="text-green-600 hover:text-green-800 font-medium"
                    >
                        🏗 Конструктор
                    </a>

                    <a
                        href="{{ route('admin.courses.sections.index', $course) }}"
                        class="text-green-600 hover:text-green-800 font-medium mr-4"
                    >
                        📚 Разделы
                    </a>

                    <a
                        href="{{ route('admin.courses.edit', $course) }}"
                        class="text-indigo-600 hover:text-indigo-800 font-medium mr-4"
                    >
                        ✏️ Изменить
                    </a>

                    <button
                        type="button"
                        wire:click="delete({{ $course->id }})"
                        wire:confirm="Вы действительно хотите удалить курс «{{ $course->title }}»?"
                        class="text-red-600 hover:text-red-800 font-medium"
                    >
                        🗑️ Удалить
                    </button>

                </td>
                
            </tr>

        @empty

            <tr>
                <td colspan="6" class="text-center py-6">
                    Курсы отсутствуют.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>
