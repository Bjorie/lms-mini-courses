<?php

namespace App\Livewire\Forms;

use App\Models\Course;
use App\Models\Section;
use Livewire\Form;

class SectionForm extends Form
{
    public ?Section $section = null;

    public ?int $course_id = null;

    public string $title = '';

    public int $position = 1;

    protected function rules(): array
    {
        return [
            'course_id' => [
                'required',
                'integer',
                'exists:courses,id',
            ],

            'title' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],

            'position' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }

    public function setCourse(Course $course): void
    {
        $this->course_id = $course->id;
        $this->position = $this->nextPosition();
    }

    public function setSection(Section $section): void
    {
        $this->section = $section;

        $this->course_id = $section->course_id;
        $this->title = $section->title;
        $this->position = $section->position;
    }

    public function store(): Section
    {
        $this->validate();

        $section = Section::create([
            'course_id' => $this->course_id,
            'title' => $this->title,
            'position' => $this->position,
        ]);

        $this->section = $section;

        return $section;
    }

    public function update(): void
    {
        if (! $this->section) {
            return;
        }

        $this->validate();

        $this->section->update([
            'title' => $this->title,
            'position' => $this->position,
        ]);
    }

    public function resetForm(): void
    {
        $courseId = $this->course_id;

        $this->reset();

        $this->section = null;
        $this->course_id = $courseId;
        $this->title = '';
        $this->position = $this->nextPosition();
    }

    private function nextPosition(): int
    {
        if ($this->course_id === null) {
            return 1;
        }

        return (
            Section::query()
                ->where('course_id', $this->course_id)
                ->max('position') ?? 0
        ) + 1;
    }
}