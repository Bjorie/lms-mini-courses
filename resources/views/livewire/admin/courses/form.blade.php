<div class="max-w-5xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">



        <a
            href="{{ route('admin.courses.index') }}"
            class="text-sm text-blue-600 hover:underline"
        >
            ← Назад к списку
        </a>

    </div>

    <form wire:submit="save" class="space-y-6">

        {{-- Название курса --}}
        <div>

            <x-input-label
                for="title"
                value="Название курса"
            />

            <x-text-input
                id="title"
                wire:model.live.debounce.700ms="form.title"
                class="mt-1 block w-full"
            />

            <x-input-error
                :messages="$errors->get('form.title')"
                class="mt-2"
            />

        </div>

        {{-- Slug --}}
        <div>

            <x-input-label
                for="slug"
                value="Slug"
            />

            <x-text-input
                id="slug"
                wire:model.blur="form.slug"
                class="mt-1 block w-full"
            />

            <x-input-error
                :messages="$errors->get('form.slug')"
                class="mt-2"
            />

            <p class="mt-1 text-sm text-gray-500">
                URL курса. Можно изменить вручную.
            </p>

        </div>        

        {{-- Категория --}}
        <div>

            <x-input-label
                for="category"
                value="Категория"
            />

            <select
                wire:model="form.category_id"
                class="mt-1 block w-full rounded-md border-gray-300"
            >

                <option value="">
                    Выберите категорию
                </option>

                @foreach($categories as $category)

                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>

                @endforeach

            </select>

            <x-input-error
                :messages="$errors->get('form.category_id')"
                class="mt-2"
            />

        </div>

        {{-- Цена --}}
        <div>

            <x-input-label
                for="price"
                value="Цена"
            />

            <x-text-input
                id="price"
                type="number"
                step="0.01"
                wire:model="form.price"
                class="mt-1 block w-full"
            />

            <x-input-error
                :messages="$errors->get('form.price')"
                class="mt-2"
            />

        </div>

        {{-- Уровень --}}        
        <div>

            <x-input-label value="Уровень"/>

            <select
                wire:model="form.level"
                class="mt-1 block w-full rounded-md border-gray-300"
            >

                @foreach($levels as $level)

                    <option value="{{ $level->value }}">

                        {{ $level->label() }}

                    </option>

                @endforeach

            </select>

        </div>

        {{-- Статус --}}
        <div>

            <x-input-label value="Статус"/>

            <select
                wire:model="form.status"
                class="mt-1 block w-full rounded-md border-gray-300"
            >

                @foreach($statuses as $status)

                    <option value="{{ $status->value }}">

                        {{ $status->label() }}

                    </option>

                @endforeach

            </select>

        </div>

        {{-- Короткое описание --}}
        <div>

            <x-input-label value="Краткое описание"/>

            <textarea

                wire:model="form.short_description"

                rows="3"

                class="mt-1 block w-full rounded-md border-gray-300"

            ></textarea>

        </div>
        
        {{-- Полное описание --}}
        <div>

            <x-input-label value="Полное описание"/>

            <textarea

                wire:model="form.description"

                rows="8"

                class="mt-1 block w-full rounded-md border-gray-300"

            ></textarea>

        </div>


        <div class="flex justify-end">

            <x-primary-button>
                Создать курс
            </x-primary-button>

        </div>

    </form>

</div>
