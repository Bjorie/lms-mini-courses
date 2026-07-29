<?php

namespace App\Livewire\Admin\Sections;

use App\Models\Course;
use App\Models\Section;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    public Course $course;

    public string $title = '';

    public function mount(Course $course): void
    {
        $this->course = $course;
    }

    public function save(): void
    {
        $this->validate([
            'title' => ['required', 'min:3', 'max:255'],
        ]);

        Section::create([
            'course_id' => $this->course->id,

            'title' => $this->title,

            'position' => (
                $this->course
                    ->sections()
                    ->max('position') ?? 0
            ) + 1,
        ]);

        session()->flash(
            'success',
            'Раздел успешно создан.'
        );

        $this->redirectRoute(
            'admin.courses.sections.index',
            $this->course
        );
    }

    public function render(): View
    {
        return view('livewire.admin.sections.create')
            ->layout('layouts.app');
    }
}