<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use App\Services\Dashboard\DashboardCacheService;

class Dashboard extends Component
{
    public int $coursesCount = 0;

    public int $publishedCoursesCount = 0;

    public int $studentsCount = 0;

    public int $enrollmentsCount = 0;

    /** @var Collection<int, Course> */
    public Collection $latestCourses;

    public function mount(): void
    {
        $stats = Cache::remember(
            DashboardCacheService::STATS_KEY,
            now()->addMinutes(5),
            function (): array {
                return [
                    'courses_count' => Course::count(),
                    'published_courses_count' => Course::published()->count(),
                    'students_count' => User::role('student')->count(),
                    'enrollments_count' => Enrollment::count(),
                ];
            }
        );

        $this->coursesCount = $stats['courses_count'];
        $this->publishedCoursesCount = $stats['published_courses_count'];
        $this->studentsCount = $stats['students_count'];
        $this->enrollmentsCount = $stats['enrollments_count'];

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