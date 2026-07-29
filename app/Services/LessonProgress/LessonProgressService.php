<?php

namespace App\Services\LessonProgress;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LessonProgressService
{
    public function complete(
        User $user,
        Lesson $lesson,
    ): LessonProgress {
        return DB::transaction(function () use (
            $user,
            $lesson,
        ): LessonProgress {
            $progress = LessonProgress::query()->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'lesson_id' => $lesson->id,
                ],
                [
                    'completed_at' => now(),
                ],
            );

            $lesson->loadMissing('section.course');

            $this->completeCourseIfEligible(
                $user,
                $lesson->section->course,
            );

            return $progress;
        });
    }

    public function isCompleted(
        User $user,
        Lesson $lesson,
    ): bool {
        return LessonProgress::query()
            ->whereBelongsTo($user)
            ->whereBelongsTo($lesson)
            ->exists();
    }

    public function percentage(
        User $user,
        Course $course,
    ): int {
        [
            'total' => $total,
            'completed' => $completed,
        ] = $this->statistics($user, $course);

        if ($total === 0) {
            return 0;
        }

        return (int) round(
            ($completed / $total) * 100
        );
    }

    public function isCourseCompleted(
        User $user,
        Course $course,
    ): bool {
        [
            'total' => $total,
            'completed' => $completed,
        ] = $this->statistics($user, $course);

        return $total > 0
            && $completed === $total;
    }

    public function nextLesson(
        User $user,
        Course $course,
    ): ?Lesson {
        $course->loadMissing('sections.lessons');

        $completedLessonIds = LessonProgress::query()
            ->whereBelongsTo($user)
            ->whereHas(
                'lesson.section',
                fn ($query) => $query->whereBelongsTo(
                    $course
                )
            )
            ->pluck('lesson_id');

        return $course->sections
            ->flatMap(
                fn ($section) => $section->lessons
            )
            ->first(
                fn (Lesson $lesson): bool => ! $completedLessonIds
                    ->contains($lesson->id)
            );
    }

    public function totalLessons(Course $course): int
    {
        return Lesson::query()
            ->whereHas(
                'section',
                fn ($query) => $query->whereBelongsTo(
                    $course
                )
            )
            ->count();
    }

    public function completedLessons(
        User $user,
        Course $course,
    ): int {
        return LessonProgress::query()
            ->whereBelongsTo($user)
            ->whereHas(
                'lesson.section',
                fn ($query) => $query->whereBelongsTo(
                    $course
                )
            )
            ->count();
    }

    private function completeCourseIfEligible(
        User $user,
        Course $course,
    ): void {
        if (! $this->isCourseCompleted($user, $course)) {
            return;
        }

        $user->enrollments()
            ->whereBelongsTo($course)
            ->whereNull('completed_at')
            ->update([
                'completed_at' => now(),
            ]);
    }

    /**
     * @return array{total: int, completed: int}
     */
    private function statistics(
        User $user,
        Course $course,
    ): array {
        return [
            'total' => $this->totalLessons($course),
            'completed' => $this->completedLessons(
                $user,
                $course,
            ),
        ];
    }
}