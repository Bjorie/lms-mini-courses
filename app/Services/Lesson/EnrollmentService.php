<?php

namespace App\Services\Enrollment;

use App\Exceptions\AlreadyEnrolledException;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class EnrollmentService
{
    /**
     * Enrolls a user in a course.
     *
     * @throws AlreadyEnrolledException
     * @throws InvalidArgumentException
     */
    public function enroll(
        User $user,
        Course $course,
        float $paidAmount = 0,
    ): Enrollment {
        if ($paidAmount < 0) {
            throw new InvalidArgumentException(
                'Сумма оплаты не может быть отрицательной.'
            );
        }

        return DB::transaction(function () use (
            $user,
            $course,
            $paidAmount,
        ): Enrollment {
            if ($this->isEnrolled($user, $course)) {
                throw new AlreadyEnrolledException(
                    'Вы уже записаны на курс.'
                );
            }

            return Enrollment::query()->create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'paid_amount' => $paidAmount,
                'enrolled_at' => now(),
            ]);
        });
    }

    /**
     * Removes the user's enrollment from the course.
     */
    public function unenroll(
        User $user,
        Course $course,
    ): void {
        Enrollment::query()
            ->whereBelongsTo($user)
            ->whereBelongsTo($course)
            ->delete();
    }

    /**
     * Determines whether the user is enrolled in the course.
     */
    public function isEnrolled(
        User $user,
        Course $course,
    ): bool {
        return Enrollment::query()
            ->whereBelongsTo($user)
            ->whereBelongsTo($course)
            ->exists();
    }
}