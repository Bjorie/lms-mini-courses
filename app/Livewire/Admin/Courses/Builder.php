<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use Livewire\Component;
use App\Livewire\Forms\LessonForm;
use Illuminate\Support\Str;
use App\Models\Lesson;

class Builder extends Component
{
    public Course $course;
    public LessonForm $lessonForm;
    public ?int $addingToSection = null;
    public ?int $editingLesson = null;


    public function mount(Course $course): void
    {
        $this->course = $course->load([
            'sections.lessons',
        ]);
    }
    public function showLessonForm(int $sectionId): void
    {
        $this->addingToSection = $sectionId;

        //$this->lessonForm->reset();
        $this->lessonForm->resetForm();

        $this->lessonForm->section_id = $sectionId;
    }
    public function cancelLesson(): void
    {
        //$this->lessonForm->reset();

        $this->lessonForm->resetForm();
        $this->addingToSection = null;

        $this->editingLesson = null;
    }
    public function saveLesson(): void
    {
        
    //logger('SAVE LESSON');
        $this->lessonForm->store();

        $this->course->load([
            'sections.lessons',
        ]);

        $this->cancelLesson();

        session()->flash(
            'success',
            'Урок успешно создан.'
        );
    }
    public function editLesson(int $lessonId): void
    {
        $lesson = Lesson::findOrFail($lessonId);
        $this->editingLesson = $lesson->id;
        $this->addingToSection = $lesson->section_id;
        $this->lessonForm->setLesson($lesson);
    }  
    public function updatedLessonFormTitle(string $value): void
    {
        if (blank($this->lessonForm->slug)) {
            $this->lessonForm->slug = Str::slug($value);
        }
    }

    public function updateLesson(): void
    {
        $this->lessonForm->update();

        $this->course->load([
            'sections.lessons',
        ]);

        $this->cancelLesson();

        session()->flash(
            'success',
            'Урок успешно обновлен.'
        );
    }  
    public function deleteLesson(int $lessonId): void
    {
        $lesson = Lesson::findOrFail($lessonId);

        if ($this->editingLesson === $lesson->id) {
            $this->cancelLesson();
        }

        $lesson->delete();

        $this->course->load([
            'sections.lessons',
        ]);

        session()->flash(
            'success',
            'Урок успешно удалён.'
        );
    }
    public function render()
    {
        return view(
            'livewire.admin.courses.builder'
        )->layout('layouts.app');
    }
}