<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth',
    'verified',
    'role:student'
])
->prefix('student')
->name('student.')
->group(function () {

    Route::view('/', 'student.dashboard')
        ->name('dashboard');

});