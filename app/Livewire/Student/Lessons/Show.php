<?php

namespace App\Livewire\Student\Lessons;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use App\Services\LessonProgress\LessonProgressService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class Show extends Component
{
    protected LessonProgressService $progressService;

    public Lesson $lesson;

    public ?Lesson $previousLesson = null;

    public ?Lesson $nextLesson = null;

    public bool $isCompleted = false;

    public int $progressPercentage = 0;

    public function boot(
        LessonProgressService $progressService,
    ): void {
        $this->progressService = $progressService;
    }

    public function mount(Lesson $lesson): void
    {
        $this->lesson = $lesson->load([
            'section.course.sections.lessons',
        ]);

        $user = $this->authenticatedUser();

        abort_unless(
            $user->hasAccessToCourse($this->course()),
            403,
        );

        $this->loadNavigation();
        $this->loadProgress($user);
    }

    public function complete(): void
    {
        $user = $this->authenticatedUser();

        abort_unless(
            $user->hasAccessToCourse($this->course()),
            403,
        );

        $this->progressService->complete(
            $user,
            $this->lesson,
        );

        $this->loadProgress($user);

        session()->flash(
            'success',
            'Урок отмечен как завершённый.',
        );
    }

    private function loadNavigation(): void
    {
        $lessons = $this->courseLessons();

        $currentIndex = $lessons->search(
            fn (Lesson $lesson): bool => $lesson->is($this->lesson)
        );

        if ($currentIndex === false) {
            $this->previousLesson = null;
            $this->nextLesson = null;

            return;
        }

        $this->previousLesson = $currentIndex > 0
            ? $lessons->get($currentIndex - 1)
            : null;

        $this->nextLesson = $currentIndex < $lessons->count() - 1
            ? $lessons->get($currentIndex + 1)
            : null;
    }

    private function loadProgress(User $user): void
    {
        $this->isCompleted = $this->progressService
            ->isCompleted(
                $user,
                $this->lesson,
            );

        $this->progressPercentage = $this->progressService
            ->percentage(
                $user,
                $this->course(),
            );
    }

    /**
     * @return Collection<int, Lesson>
     */
    private function courseLessons(): Collection
    {
        return $this->course()
            ->sections
            ->flatMap(
                fn ($section) => $section->lessons
            )
            ->values();
    }

    private function course(): Course
    {
        return $this->lesson->section->course;
    }

    private function authenticatedUser(): User
    {
        $user = auth()->user();

        abort_unless($user instanceof User, 403);

        return $user;
    }

    public function render(): View
    {
        return view('livewire.student.lessons.show')
            ->layout('layouts.app');
    }
}