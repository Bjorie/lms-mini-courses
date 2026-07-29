<?php

use App\Livewire\Student\Courses\Index as CourseIndex;
use App\Livewire\Student\Courses\Show as CourseShow;
use App\Livewire\Student\Dashboard;
use App\Livewire\Student\Lessons\Show as LessonShow;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth',
    'verified',
    'role:student|admin',
])
    ->prefix('student')
    ->name('student.')
    ->group(function (): void {
        Route::get('/', Dashboard::class)
            ->name('dashboard');

        Route::get('/courses', CourseIndex::class)
            ->name('courses.index');

        Route::get('/courses/{course}', CourseShow::class)
            ->name('courses.show');

        Route::get('/lessons/{lesson}', LessonShow::class)
            ->name('lessons.show');
    });