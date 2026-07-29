<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Dashboard extends Component
{
    public int $coursesCount = 0;

    public int $publishedCoursesCount = 0;

    public int $studentsCount = 0;

    public int $enrollmentsCount = 0;

    /** @var Collection<int, \App\Models\Course> */
    public Collection $latestCourses;

    public function mount(): void
    {
        $this->coursesCount = Course::count();

        $this->publishedCoursesCount = Course::published()->count();

        $this->studentsCount = User::role('student')->count();

        $this->enrollmentsCount = Enrollment::count();

        $this->latestCourses = Course::query()
            ->with('author')
            ->latest()
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('layouts.app')
            ->title('Панель администратора');
    }
}