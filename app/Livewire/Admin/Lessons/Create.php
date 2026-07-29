<?php

namespace App\Livewire\Admin\Lessons;

use App\DTO\Lesson\LessonData;
use App\Livewire\Forms\LessonForm;
use App\Models\Section;
use App\Services\Lesson\LessonService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    public LessonForm $form;

    public Section $section;

    protected LessonService $lessonService;

    public function boot(
        LessonService $lessonService
    ): void {
        $this->lessonService = $lessonService;
    }

    public function mount(Section $section): void
    {
        $this->section = $section;
        $this->form->section_id = $section->id;
    }

    public function save()
    {
        $this->form->generateSlug();
        $this->form->validate();

        $data = LessonData::fromForm(
            $this->form
        );

        $lesson = $this->lessonService->create(
            $data
        );

        session()->flash(
            'success',
            'Урок успешно создан.'
        );

        return redirect()->route(
            'admin.lessons.edit',
            $lesson
        );
    }

    public function render(): View
    {
        return view(
            'livewire.admin.lessons.create'
        )->layout('layouts.app');
    }
}