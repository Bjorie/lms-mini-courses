<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public function delete(Course $course): void
    {
        $course->delete();

        session()->flash(
            'success',
            'Курс успешно удалён.'
        );
    }

    public function render(): View
    {
        return view('livewire.admin.courses.index', [
            'courses' => Course::query()
                ->with([
                    'category',
                    'author',
                ])
                ->latest()
                ->get(),
        ])->layout('layouts.app');
    }
}