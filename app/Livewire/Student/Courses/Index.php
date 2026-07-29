<?php

namespace App\Livewire\Student\Courses;

use App\Models\Course;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render(): View
    {
        $userId = auth()->id();

        $courses = Course::query()
            ->with([
                'author',
                'category',
            ])
            ->withExists([
                'enrollments as is_enrolled' => fn ($query) => $query
                    ->where('user_id', $userId),
            ])
            ->published()
            ->latest('published_at')
            ->paginate(12);

        return view('livewire.student.courses.index', [
            'courses' => $courses,
        ])
            ->layout('layouts.app')
            ->title('Каталог курсов');
    }
}