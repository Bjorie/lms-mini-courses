<div class="py-8">
    <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

        @if (session()->has('success'))
            <div
                class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800"
                role="alert"
            >
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div
                class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800"
                role="alert"
            >
                {{ session('error') }}
            </div>
        @endif

        <section class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                    Категории курсов
                </h1>

                <p class="mt-1 text-sm text-gray-600">
                    Управляйте категориями, по которым распределяются учебные курсы.
                </p>
            </div>

            <a
                href="{{ route('admin.categories.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                Создать категорию
            </a>
        </section>

        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            @if ($categories->isEmpty())
                <div class="px-6 py-16 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-50 text-blue-600">
                        <svg
                            class="h-6 w-6"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M7 7h.01M3 11.5V5a2 2 0 0 1 2-2h6.5a2 2 0 0 1 1.4.58l7.52 7.52a2 2 0 0 1 0 2.83l-6.49 6.49a2 2 0 0 1-2.83 0L3.58 12.9A2 2 0 0 1 3 11.5Z"
                            />
                        </svg>
                    </div>

                    <h2 class="mt-4 text-lg font-semibold text-gray-900">
                        Категорий пока нет
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Создайте первую категорию, чтобы распределять по ней курсы.
                    </p>

                    <a
                        href="{{ route('admin.categories.create') }}"
                        class="mt-6 inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                    >
                        Создать категорию
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Название
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Slug
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Курсов
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Действия
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($categories as $category)
                                <tr
                                    wire:key="category-{{ $category->id }}"
                                    class="transition hover:bg-gray-50"
                                >
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="font-semibold text-gray-900">
                                            {{ $category->name }}
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                        {{ $category->slug }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="inline-flex min-w-8 items-center justify-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700">
                                            {{ $category->courses_count }}
                                        </span>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-right">
                                        <div class="flex flex-wrap justify-end gap-2">
                                            <a
                                                href="{{ route('admin.categories.edit', $category) }}"
                                                class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
                                            >
                                                Изменить
                                            </a>

                                            <button
                                                type="button"
                                                wire:click="delete({{ $category->id }})"
                                                wire:confirm="Удалить категорию «{{ $category->name }}»?"
                                                wire:loading.attr="disabled"
                                                wire:target="delete({{ $category->id }})"
                                                class="inline-flex items-center rounded-lg border border-red-200 bg-white px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-50"
                                            >
                                                Удалить
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
</div>