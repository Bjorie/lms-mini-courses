<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
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
    public function render()
    {
        return view('livewire.admin.courses.index', [
            'courses' => Course::with([
                'category',
                'author',
            ])
            ->orderBy('title')
            ->get(),
        ])->layout('layouts.app');
    }
}