                    <div class="mt-6 rounded-lg border bg-gray-50 p-4">

                        <div class="space-y-5">

                            {{-- Название --}}
                            <div>

                                <x-input-label
                                    for="lesson-title"
                                    value="Название урока"
                                />

                                <x-text-input
                                    id="lesson-title"
                                    wire:model="lessonForm.title"
                                    class="mt-1 block w-full"
                                />

                                <x-input-error
                                    :messages="$errors->get('lessonForm.title')"
                                    class="mt-2"
                                />

                            </div>

                            {{-- Slug --}}
                            <div>

                                <x-input-label
                                    for="lesson-slug"
                                    value="Slug"
                                />

                                <x-text-input
                                    id="lesson-slug"
                                    wire:model="lessonForm.slug"
                                    class="mt-1 block w-full"
                                />

                                <x-input-error
                                    :messages="$errors->get('lessonForm.slug')"
                                    class="mt-2"
                                />

                            </div>

                            {{-- Видео --}}
                            <div>

                                <x-input-label
                                    for="video-url"
                                    value="Ссылка на видео"
                                />

                                <x-text-input
                                    id="video-url"
                                    wire:model="lessonForm.video_url"
                                    class="mt-1 block w-full"
                                />

                            </div>

                            {{-- Продолжительность --}}
                            <div>

                                <x-input-label
                                    for="lesson-duration"
                                    value="Продолжительность (сек.)"
                                />

                                <x-text-input
                                    id="lesson-duration"
                                    type="number"
                                    min="0"
                                    wire:model="lessonForm.duration"
                                    class="mt-1 block w-full"
                                />

                            </div>

                            {{-- Контент --}}
                            <div>

                                <x-input-label
                                    for="lesson-content"
                                    value="Содержимое урока"
                                />

                                <textarea
                                    id="lesson-content"
                                    rows="10"
                                    wire:model="lessonForm.content"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                ></textarea>

                            </div>

                            {{-- Бесплатный --}}
                            <label class="flex items-center gap-2">

                                <input
                                    type="checkbox"
                                    wire:model="lessonForm.is_free"
                                    class="rounded border-gray-300"
                                >

                                <span>Бесплатный урок</span>

                            </label>

                            {{-- Опубликован --}}
                            <label class="flex items-center gap-2">

                                <input
                                    type="checkbox"
                                    wire:model="lessonForm.is_published"
                                    class="rounded border-gray-300"
                                >

                                <span>Опубликован</span>

                            </label>

                            <div class="flex gap-3">

                                @if($editingLesson)

                                    <x-primary-button wire:click="updateLesson">
                                        Обновить
                                    </x-primary-button>

                                @else

                                    <x-primary-button wire:click="saveLesson">
                                        Сохранить
                                    </x-primary-button>

                                @endif

                                <x-secondary-button wire:click="cancelLesson">
                                    Отмена
                                </x-secondary-button>

                            </div>

                        </div>

                    </div>