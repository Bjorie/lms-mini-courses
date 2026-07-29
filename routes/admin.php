<?php

use App\Livewire\Admin\Categories\Create as CategoryCreate;
use App\Livewire\Admin\Categories\Edit as CategoryEdit;
use App\Livewire\Admin\Categories\Index as CategoryIndex;
use App\Livewire\Admin\Courses\Builder;
use App\Livewire\Admin\Courses\Create as CourseCreate;
use App\Livewire\Admin\Courses\Edit as CourseEdit;
use App\Livewire\Admin\Courses\Index as CourseIndex;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Lessons\Create as LessonCreate;
use App\Livewire\Admin\Lessons\Edit as LessonEdit;
use App\Livewire\Admin\Lessons\Index as LessonIndex;
use App\Livewire\Admin\Sections\Create as SectionCreate;
use App\Livewire\Admin\Sections\Edit as SectionEdit;
use App\Livewire\Admin\Sections\Index as SectionIndex;
use App\Livewire\Admin\Users\Index as UserIndex;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth',
    'verified',
    'role:admin',
])
    ->prefix('admin')
    ->name('admin.')
    ->scopeBindings()
    ->group(function () {
        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */
        Route::get('/', Dashboard::class)
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */
        Route::get('/users', UserIndex::class)
            ->name('users.index');

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */
        Route::get('/categories', CategoryIndex::class)
            ->name('categories.index');

        Route::get('/categories/create', CategoryCreate::class)
            ->name('categories.create');

        Route::get('/categories/{category}/edit', CategoryEdit::class)
            ->name('categories.edit');

        /*
        |--------------------------------------------------------------------------
        | Courses
        |--------------------------------------------------------------------------
        */
        Route::get('/courses', CourseIndex::class)
            ->name('courses.index');

        Route::get('/courses/create', CourseCreate::class)
            ->name('courses.create');

        Route::get('/courses/{course}/edit', CourseEdit::class)
            ->name('courses.edit');

        Route::get('/courses/{course}/builder', Builder::class)
            ->name('courses.builder');

        /*
        |--------------------------------------------------------------------------
        | Sections
        |--------------------------------------------------------------------------
        */
        Route::get(
            '/courses/{course}/sections',
            SectionIndex::class
        )->name('courses.sections.index');

        Route::get(
            '/courses/{course}/sections/create',
            SectionCreate::class
        )->name('courses.sections.create');

        Route::get(
            '/sections/{section}/edit',
            SectionEdit::class
        )->name('sections.edit');

        /*
        |--------------------------------------------------------------------------
        | Lessons
        |--------------------------------------------------------------------------
        */

        // Route::get(
        //     '/sections/{section}/lessons',
        //     LessonIndex::class
        // )->name('sections.lessons.index');

        // Route::get(
        //     '/sections/{section}/lessons/create',
        //     LessonCreate::class
        // )->name('sections.lessons.create');

        Route::get('/lessons/{lesson}/edit', LessonEdit::class)
            ->name('lessons.edit');
    });