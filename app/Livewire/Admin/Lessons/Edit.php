<?php

namespace App\Livewire\Admin\Lessons;

use App\DTO\Lesson\LessonData;
use App\Livewire\Forms\LessonForm;
use App\Models\Lesson;
use App\Services\Lesson\LessonService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;

class Edit extends Component
{
    public LessonForm $form;

    protected LessonService $lessonService;

    public function boot(LessonService $lessonService): void
    {
        $this->lessonService = $lessonService;
    }

    public function mount(Lesson $lesson): void
    {
        $this->form->setLesson($lesson);
    }

    public function save(): RedirectResponse
    {
        $this->form->generateSlug();
        $this->form->validate();

        $data = LessonData::fromForm($this->form);

        $this->lessonService->update(
            $this->form->lesson,
            $data
        );

        session()->flash(
            'success',
            'Урок успешно обновлён.'
        );

        return redirect()->route(
            'admin.lessons.edit',
            $this->form->lesson
        );
    }

    public function render(): View
    {
        return view('livewire.admin.lessons.edit')
            ->layout('layouts.app');
    }
}