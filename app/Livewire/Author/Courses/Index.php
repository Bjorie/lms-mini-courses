<?php

namespace App\Livewire\Author\Courses;

use App\Models\Course;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public function render(): View
    {
        $courses = Course::query()
            ->where('author_id', auth()->id())
            ->latest()
            ->get();

        return view('livewire.author.courses.index', [
            'courses' => $courses,
        ]);
    }
}