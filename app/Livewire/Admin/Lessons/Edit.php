<?php

namespace App\Livewire\Admin\Lessons;

use App\Livewire\Forms\LessonForm;
use App\Models\Lesson;
use Livewire\Component;
use App\Services\Lesson\LessonService;
use App\DTO\Lesson\UpdateLessonData;

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

    public function save()
    {
        $this->form->validate();

        $dto = UpdateLessonData::fromForm($this->form);

        $this->lessonService->update(
            $this->form->lesson,
            $dto
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

    public function render()
    {
        return view('livewire.admin.lessons.edit')
            ->layout('layouts.app');
    }
}
