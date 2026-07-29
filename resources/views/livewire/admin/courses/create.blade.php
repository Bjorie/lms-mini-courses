<div class="max-w-5xl mx-auto py-6">

    <h1 class="mb-2 text-2xl font-bold">
        Создание курса
    </h1>

    <p class="mb-6 text-sm text-gray-600">
        Заполните основные сведения о новом курсе.
    </p>

    @include('livewire.admin.courses.form', [
        'submitLabel' => 'Создать курс',
    ])

</div>