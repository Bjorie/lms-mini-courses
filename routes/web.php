<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('dashboard', function (): RedirectResponse {
    $user = request()->user();

    abort_unless($user !== null, 403);

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif (
        $user->hasRole('author')
        && Route::has('author.dashboard')
    ) {
        return redirect()->route('author.dashboard');
    } elseif ($user->hasRole('student')) {
        return redirect()->route('student.dashboard');
    }

    abort(403, 'User does not have an available dashboard.');
})
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware('auth')
    ->name('profile');

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/author.php';
require __DIR__ . '/student.php';