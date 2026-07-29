<?php

namespace Tests\Feature\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Section;
use App\Models\User;
use App\Services\LessonProgress\LessonProgressService;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class LessonProgressServiceTest extends TestCase
{
    use RefreshDatabase;

    private LessonProgressService $service;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $this->seed(RoleSeeder::class);

        $this->service = app(LessonProgressService::class);
    }

    public function test_user_can_complete_lesson(): void
    {
        $user = User::factory()->create();
        $lesson = $this->createLesson();

        $progress = $this->service->complete($user, $lesson);

        $this->assertInstanceOf(
            LessonProgress::class,
            $progress
        );

        $this->assertDatabaseHas('lesson_progress', [
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
        ]);

        $this->assertNotNull($progress->completed_at);
    }

    public function test_completing_same_lesson_twice_does_not_create_duplicate(): void
    {
        $user = User::factory()->create();
        $lesson = $this->createLesson();

        $this->service->complete($user, $lesson);
        $this->service->complete($user, $lesson);

        $this->assertDatabaseCount('lesson_progress', 1);
    }

    public function test_service_detects_completed_lesson(): void
    {
        $user = User::factory()->create();
        $lesson = $this->createLesson();

        $this->assertFalse(
            $this->service->isCompleted($user, $lesson)
        );

        $this->service->complete($user, $lesson);

        $this->assertTrue(
            $this->service->isCompleted($user, $lesson)
        );
    }

    public function test_service_returns_total_number_of_course_lessons(): void
    {
        $course = Course::factory()->create();
        $section = Section::factory()
            ->for($course)
            ->create();

        Lesson::factory()
            ->count(3)
            ->for($section)
            ->create();

        $this->assertSame(
            3,
            $this->service->totalLessons($course)
        );
    }

    public function test_service_returns_number_of_completed_lessons(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $section = Section::factory()
            ->for($course)
            ->create();

        $lessons = Lesson::factory()
            ->count(3)
            ->for($section)
            ->create();

        $this->service->complete($user, $lessons[0]);
        $this->service->complete($user, $lessons[1]);

        $this->assertSame(
            2,
            $this->service->completedLessons($user, $course)
        );
    }

    public function test_service_calculates_course_progress_percentage(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $section = Section::factory()
            ->for($course)
            ->create();

        $lessons = Lesson::factory()
            ->count(4)
            ->for($section)
            ->create();

        $this->service->complete($user, $lessons[0]);
        $this->service->complete($user, $lessons[1]);

        $this->assertSame(
            50,
            $this->service->percentage($user, $course)
        );
    }

    public function test_percentage_is_zero_when_course_has_no_lessons(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $this->assertSame(
            0,
            $this->service->percentage($user, $course)
        );
    }

    public function test_course_is_completed_when_all_lessons_are_completed(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $section = Section::factory()
            ->for($course)
            ->create();

        $lessons = Lesson::factory()
            ->count(2)
            ->for($section)
            ->create();

        foreach ($lessons as $lesson) {
            $this->service->complete($user, $lesson);
        }

        $this->assertTrue(
            $this->service->isCourseCompleted($user, $course)
        );
    }

    public function test_course_is_not_completed_when_some_lessons_are_incomplete(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $section = Section::factory()
            ->for($course)
            ->create();

        $lessons = Lesson::factory()
            ->count(2)
            ->for($section)
            ->create();

        $this->service->complete($user, $lessons[0]);

        $this->assertFalse(
            $this->service->isCourseCompleted($user, $course)
        );
    }

    public function test_empty_course_is_not_considered_completed(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $this->assertFalse(
            $this->service->isCourseCompleted($user, $course)
        );
    }

    public function test_completing_all_lessons_sets_enrollment_completed_at(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $section = Section::factory()
            ->for($course)
            ->create();

        $lessons = Lesson::factory()
            ->count(2)
            ->for($section)
            ->create();

        $enrollment = Enrollment::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'paid_amount' => 0,
            'enrolled_at' => now(),
            'completed_at' => null,
        ]);

        $this->service->complete($user, $lessons[0]);

        $this->assertNull(
            $enrollment->fresh()->completed_at
        );

        $this->service->complete($user, $lessons[1]);

        $this->assertNotNull(
            $enrollment->fresh()->completed_at
        );
    }

    public function test_next_lesson_returns_first_lesson_when_user_has_no_progress(): void
    {
        $user = User::factory()->create();

        $course = Course::factory()->create();

        $section = Section::factory()
            ->for($course)
            ->create();

        $lessons = Lesson::factory()
            ->count(3)
            ->for($section)
            ->create();

        $nextLesson = $this->service->nextLesson(
            $user,
            $course,
        );

        $this->assertTrue(
            $nextLesson->is($lessons[0])
        );
    }

    public function test_next_lesson_returns_first_incomplete_lesson(): void
    {
        $user = User::factory()->create();

        $course = Course::factory()->create();

        $section = Section::factory()
            ->for($course)
            ->create();

        $lessons = Lesson::factory()
            ->count(3)
            ->for($section)
            ->create();

        $this->service->complete($user, $lessons[0]);

        $nextLesson = $this->service->nextLesson(
            $user,
            $course,
        );

        $this->assertTrue(
            $nextLesson->is($lessons[1])
        );
    }

    public function test_next_lesson_returns_null_when_course_is_completed(): void
    {
        $user = User::factory()->create();

        $course = Course::factory()->create();

        $section = Section::factory()
            ->for($course)
            ->create();

        $lessons = Lesson::factory()
            ->count(2)
            ->for($section)
            ->create();

        foreach ($lessons as $lesson) {
            $this->service->complete($user, $lesson);
        }

        $this->assertNull(
            $this->service->nextLesson(
                $user,
                $course,
            )
        );
    }

    public function test_course_completion_date_is_not_overwritten(): void
    {
        Carbon::setTestNow('2026-07-25 10:00:00');

        $user = User::factory()->create();
        $course = Course::factory()->create();
        $section = Section::factory()
            ->for($course)
            ->create();

        $lessons = Lesson::factory()
            ->count(2)
            ->for($section)
            ->create();

        $enrollment = Enrollment::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'paid_amount' => 0,
            'enrolled_at' => now(),
            'completed_at' => null,
        ]);
        foreach ($lessons as $lesson) {
            $this->service->complete($user, $lesson);
        }

        $originalCompletedAt = $enrollment
            ->fresh()
            ->completed_at;

        Carbon::setTestNow('2026-07-26 10:00:00');

        $this->service->complete($user, $lessons[1]);

        $this->assertTrue(
            $originalCompletedAt->equalTo(
                $enrollment->fresh()->completed_at
            )
        );
    }

    private function createLesson(): Lesson
    {
        $course = Course::factory()->create();

        $section = Section::factory()
            ->for($course)
            ->create();

        return Lesson::factory()
            ->for($section)
            ->create();
    }
}