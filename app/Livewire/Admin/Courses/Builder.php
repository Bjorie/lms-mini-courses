<?php

namespace App\Livewire\Admin\Courses;

use App\Livewire\Forms\LessonForm;
use App\Livewire\Forms\SectionForm;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;

class Builder extends Component
{
    public Course $course;

    public LessonForm $lessonForm;

    public SectionForm $sectionForm;

    public ?int $addingToSection = null;

    public ?int $editingLesson = null;

    public ?int $editingSection = null;

    public bool $showSectionForm = false;

    public function mount(Course $course): void
    {
        $this->course = $course;
        
        $this->sectionForm->setCourse($course);

        $this->refreshCourse();
    }

    public function showSectionForm(): void
    {
        $this->sectionForm->resetForm();
        $this->sectionForm->setCourse($this->course);

        $this->editingSection = null;
        $this->showSectionForm = true;
    }

    public function cancelSection(): void
    {
        $this->sectionForm->resetForm();

        $this->editingSection = null;
        $this->showSectionForm = false;
    }

    public function saveSection(): void
    {
        $this->sectionForm->store();

        $this->cancelSection();

        $this->refreshCourse();

        session()->flash(
            'success',
            'Раздел успешно создан.'
        );
    }

    public function editSection(int $sectionId): void
    {
        $section = $this->findSection($sectionId);

        $this->sectionForm->setSection($section);

        $this->editingSection = $section->id;
        $this->showSectionForm = true;
    }

    public function updateSection(): void
    {
        $this->sectionForm->update();

        $this->cancelSection();

        $this->refreshCourse();

        session()->flash(
            'success',
            'Раздел успешно обновлён.'
        );
    }

    public function deleteSection(int $sectionId): void
    {
        $section = $this->findSection($sectionId);

        if ($this->editingSection === $section->id) {
            $this->cancelSection();
        }

        $section->lessons()->delete();

        if ($section->lessons()->exists()) {

            session()->flash(
                'error',
                'Сначала удалите или перенесите все уроки раздела.'
            );

            return;
        }

        $section->delete();

        $this->sectionForm->resetForm();

        $this->refreshCourse();

        session()->flash(
            'success',
            'Раздел успешно удалён.'
        );
    }

    public function showLessonForm(int $sectionId): void
    {
        $section = $this->findSection($sectionId);

        $this->lessonForm->resetForm();
        $this->lessonForm->section_id = $section->id;

        $this->addingToSection = $section->id;
        $this->editingLesson = null;
    }

    public function cancelLesson(): void
    {
        $this->lessonForm->resetForm();

        $this->addingToSection = null;
        $this->editingLesson = null;
    }

    public function saveLesson(): void
    {
        $this->ensureSelectedSectionBelongsToCourse();

        $this->lessonForm->store();

        $this->cancelLesson();
        $this->refreshCourse();

        session()->flash(
            'success',
            'Урок успешно создан.'
        );
    }

    public function editLesson(int $lessonId): void
    {
        $lesson = $this->findLesson($lessonId);

        $this->lessonForm->setLesson($lesson);

        $this->editingLesson = $lesson->id;
        $this->addingToSection = $lesson->section_id;
    }

    public function updatedLessonFormTitle(string $value): void
    {
        if (blank($this->lessonForm->slug)) {
            $this->lessonForm->slug = Str::slug($value);
        }
    }

    public function updateLesson(): void
    {
        $this->findLesson(
            $this->editingLesson
                ?? abort(404)
        );

        $this->ensureSelectedSectionBelongsToCourse();

        $this->lessonForm->update();

        $this->cancelLesson();

        $this->refreshCourse();

        session()->flash(
            'success',
            'Урок успешно обновлён.'
        );
    }

    public function deleteLesson(int $lessonId): void
    {
        $lesson = $this->findLesson($lessonId);

        if ($this->editingLesson === $lesson->id) {
            $this->cancelLesson();
        }

        $lesson->delete();

        $this->lessonForm->resetForm();

        $this->refreshCourse();

        session()->flash(
            'success',
            'Урок успешно удалён.'
        );
    }

    public function render(): View
    {
        return view('livewire.admin.courses.builder')
            ->layout('layouts.app');
    }

    private function findSection(int $sectionId): Section
    {
        return $this->course
            ->sections()
            ->whereKey($sectionId)
            ->firstOrFail();
    }

    private function findLesson(int $lessonId): Lesson
    {
        return Lesson::query()
            ->whereKey($lessonId)
            ->whereHas(
                'section',
                fn ($query) => $query->where(
                    'course_id',
                    $this->course->id
                )
            )
            ->firstOrFail();
    }

    private function ensureSelectedSectionBelongsToCourse(): void
    {
        if ($this->lessonForm->section_id === null) {
            abort(404);
        }

        $this->findSection($this->lessonForm->section_id);
    }

    private function refreshCourse(): void
    {
        $this->course->load([
            'sections' => fn ($query) => $query->orderBy('position'),

            'sections.lessons' => fn ($query) => $query->orderBy('position'),
        ]);
    }
}