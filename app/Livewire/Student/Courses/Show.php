<?php

namespace App\Livewire\Student\Courses;

use App\Exceptions\AlreadyEnrolledException;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use App\Services\Enrollment\EnrollmentService;
use App\Services\LessonProgress\LessonProgressService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    protected EnrollmentService $enrollmentService;

    protected LessonProgressService $progressService;

    public Course $course;

    public ?Lesson $firstLesson = null;

    public ?Lesson $nextLesson = null;

    public bool $isEnrolled = false;

    public int $progressPercentage = 0;

    public int $completedLessonsCount = 0;

    public int $totalLessons = 0;

    /**
     * @var array<int, int>
     */
    public array $completedLessonIds = [];

    public function boot(
        EnrollmentService $enrollmentService,
        LessonProgressService $progressService,
    ): void {
        $this->enrollmentService = $enrollmentService;
        $this->progressService = $progressService;
    }

    public function mount(Course $course): void
    {
        $this->loadCourse($course);

        $this->firstLesson = $this->resolveFirstLesson();
        $this->totalLessons = $this->progressService
            ->totalLessons($this->course);

        $user = $this->authenticatedUser();

        if (! $user instanceof User) {
            return;
        }

        $this->isEnrolled = $user->hasAccessToCourse(
            $this->course
        );

        if ($this->isEnrolled) {
            $this->loadProgress($user);
        }
    }

    public function enroll(): void
    {
        $user = $this->authenticatedUser();

        if (! $user instanceof User) {
            $this->redirectRoute('login');

            return;
        }

        try {
            $this->enrollmentService->enroll(
                $user,
                $this->course,
            );

            $this->isEnrolled = true;

            $this->loadProgress($user);

            session()->flash(
                'success',
                'Вы успешно записались на курс.',
            );
        } catch (AlreadyEnrolledException $exception) {
            /*
             * Синхронизируем состояние компонента с базой.
             * Исключение означает, что пользователь уже записан.
             */
            $this->isEnrolled = true;

            $this->loadProgress($user);

            session()->flash(
                'warning',
                $exception->getMessage(),
            );
        }
    }

    private function loadCourse(Course $course): void
    {
        $this->course = $course->load([
            'author',
            'sections.lessons',
        ]);
    }

    private function resolveFirstLesson(): ?Lesson
    {
        return $this->course
            ->sections
            ->flatMap(
                fn ($section) => $section->lessons
            )
            ->first();
    }

    private function loadProgress(User $user): void
    {
        $this->progressPercentage = $this->progressService
            ->percentage(
                $user,
                $this->course,
            );

        $this->nextLesson = $this->progressService
            ->nextLesson(
                $user,
                $this->course,
            );

        $courseLessonIds = $this->course
            ->sections
            ->flatMap(
                fn ($section) => $section->lessons
            )
            ->pluck('id');

        $this->completedLessonIds = $user
            ->lessonProgress()
            ->whereIn('lesson_id', $courseLessonIds)
            ->pluck('lesson_id')
            ->map(
                fn ($lessonId) => (int) $lessonId
            )
            ->all();

        $this->completedLessonsCount = count(
            $this->completedLessonIds
        );
    }

    private function authenticatedUser(): ?User
    {
        $user = auth()->user();

        return $user instanceof User
            ? $user
            : null;
    }

    public function render(): View
    {
        return view('livewire.student.courses.show')
            ->layout('layouts.app');
    }
}