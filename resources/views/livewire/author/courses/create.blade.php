<div class="container py-4">
    <div class="mb-4">
        <h1 class="h3 mb-1">Создание курса</h1>
        <p class="text-muted mb-0">
            Заполните основную информацию о новом курсе.
        </p>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="save">
        <div class="card">
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Название курса</label>

                    <input
                        type="text"
                        class="form-control @error('title') is-invalid @enderror"
                        wire:model.blur="title"
                    >

                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Краткое описание</label>

                    <textarea
                        rows="3"
                        class="form-control @error('short_description') is-invalid @enderror"
                        wire:model.blur="short_description"
                    ></textarea>

                    @error('short_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Полное описание</label>

                    <textarea
                        rows="6"
                        class="form-control @error('description') is-invalid @enderror"
                        wire:model.blur="description"
                    ></textarea>

                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Категория</label>

                        <select
                            class="form-select @error('category_id') is-invalid @enderror"
                            wire:model="category_id"
                        >
                            <option value="">Выберите категорию</option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Уровень</label>

                        <select
                            class="form-select"
                            wire:model="level"
                        >
                            <option value="beginner">Начальный</option>
                            <option value="intermediate">Средний</option>
                            <option value="advanced">Продвинутый</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Статус</label>

                        <select
                            class="form-select"
                            wire:model="status"
                        >
                            <option value="draft">Черновик</option>
                            <option value="published">Опубликовать</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Стоимость</label>

                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        class="form-control @error('price') is-invalid @enderror"
                        wire:model="price"
                    >

                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="card-footer d-flex justify-content-between">
                <a
                    href="{{ route('author.courses.index') }}"
                    class="btn btn-outline-secondary"
                >
                    Отмена
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Сохранить курс
                </button>
            </div>
        </div>
    </form>
</div>