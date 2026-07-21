<?php

namespace App\Livewire\Admin\Sections;

use App\Models\Course;
use Livewire\Component;
use App\Models\Section;

class Index extends Component
{
    public Course $course;

    public function mount(Course $course): void
    {
        $this->course = $course;
    }

    public function delete(Section $section): void
    {
        $course = $section->course;

        $section->delete();

        $course->sections()
            ->orderBy('position')
            ->get()
            ->each(function ($section, $index) {
                $section->update([
                    'position' => $index + 1,
                ]);
            });

        session()->flash(
            'success',
            'Раздел успешно удалён.'
        );
    }

    public function moveUp(Section $section): void
    {
        $previous = $section->course
            ->sections()
            ->where('position', '<', $section->position)
            ->orderByDesc('position')
            ->first();

        if (! $previous) {
            return;
        }

        $currentPosition = $section->position;

        $section->update([
            'position' => $previous->position,
        ]);

        $previous->update([
            'position' => $currentPosition,
        ]);
    }

    public function moveDown(Section $section): void
    {
        $next = $section->course
            ->sections()
            ->where('position', '>', $section->position)
            ->orderBy('position')
            ->first();

        if (! $next) {
            return;
        }

        $currentPosition = $section->position;

        $section->update([
            'position' => $next->position,
        ]);

        $next->update([
            'position' => $currentPosition,
        ]);
    }

    public function render()
    {
        return view('livewire.admin.sections.index', [
            'sections' => $this->course
                ->sections()
                ->with([
                    'lessons' => fn ($query) => $query->orderBy('position'),
                ])
                ->orderBy('position')
                ->get()
        ])->layout('layouts.app');
    }
}
