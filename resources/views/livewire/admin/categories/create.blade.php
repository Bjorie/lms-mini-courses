<div class="py-8">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                Создание категории
            </h1>

            <p class="mt-1 text-sm text-gray-600">
                Создайте новую категорию для группировки учебных курсов.
            </p>
        </div>

        @include('livewire.admin.categories.form', [
            'submitLabel' => 'Создать категорию',
        ])
    </div>
</div>