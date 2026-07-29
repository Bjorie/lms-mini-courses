<?php

namespace App\Livewire\Student;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use App\Services\LessonProgress\LessonProgressService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Dashboard extends Component
{
    public string $studentName = '';

    public ?Course $currentCourse = null;

    public ?Lesson $nextLesson = null;

    public int $progress = 0;

    /**
     * @var array<int, array{
     *     id: int,
     *     title: string,
     *     progress: int,
     *     is_completed: bool,
     *     completed_at: ?string
     * }>
     */
    public array $myCourses = [];

    public function mount(
        LessonProgressService $progressService,
    ): void {
        $user = auth()->user();

        abort_unless($user instanceof User, 403);

        $this->studentName = $user->name;

        $this->loadCurrentCourse(
            $progressService,
            $user,
        );

        $this->loadMyCourses(
            $progressService,
            $user,
        );
    }

    public function render(): View
    {
        return view('livewire.student.dashboard')
            ->layout('layouts.app');
    }

    private function loadCurrentCourse(
        LessonProgressService $progressService,
        User $user,
    ): void {
        $enrollment = $user->enrollments()
            ->whereNull('completed_at')
            ->with('course')
            ->oldest('enrolled_at')
            ->first();

        if ($enrollment === null) {
            return;
        }

        $this->currentCourse = $enrollment->course;

        $this->progress = $progressService->percentage(
            $user,
            $this->currentCourse,
        );

        $this->nextLesson = $progressService->nextLesson(
            $user,
            $this->currentCourse,
        );
    }

    private function loadMyCourses(
        LessonProgressService $progressService,
        User $user,
    ): void {
        $enrollments = $user->enrollments()
            ->with('course')
            ->latest('enrolled_at')
            ->limit(3)
            ->get();

        $this->myCourses = $enrollments
            ->map(function ($enrollment) use (
                $progressService,
                $user,
            ): array {
                $course = $enrollment->course;

                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'progress' => $progressService->percentage(
                        $user,
                        $course,
                    ),
                    'is_completed' => $enrollment->completed_at !== null,
                    'completed_at' => $enrollment->completed_at?->format(
                        'd.m.Y'
                    ),
                ];
            })
            ->all();
    }
}