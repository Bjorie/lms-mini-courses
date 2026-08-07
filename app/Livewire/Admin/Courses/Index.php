<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use Livewire\Component;
use App\Services\Course\CourseCacheService;
use App\Services\Course\CourseService;

class Index extends Component
{
    public function delete(Course $course,CourseService $courseService,): void 
    {
        $courseService->delete($course);
    }

    public function render(CourseCacheService $courseCache)
    {
        return view('livewire.admin.courses.index', [
            'courses' => $courseCache->adminList(),
        ])
            ->layout('layouts.app')
            ->title('Управление курсами');
    }



}