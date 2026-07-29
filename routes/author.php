<?php

use App\Livewire\Author\Courses\Create;
use App\Livewire\Author\Courses\Edit;
use App\Livewire\Author\Courses\Index;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:author'])
    ->prefix('author')
    ->name('author.')
    ->group(function (): void {
        Route::get('/courses', Index::class)
            ->name('courses.index');

        Route::get('/courses/create', Create::class)
            ->name('courses.create');

        Route::get('/courses/{course}/edit', Edit::class)
            ->name('courses.edit');
    });