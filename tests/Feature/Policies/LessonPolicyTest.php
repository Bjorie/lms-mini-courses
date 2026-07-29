<?php

namespace Tests\Feature\Policies;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\User;
use App\Policies\LessonPolicy;
use App\Services\Enrollment\EnrollmentService;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class LessonPolicyTest extends TestCase
{
    use RefreshDatabase;

    private LessonPolicy $policy;
    private EnrollmentService $enrollmentService;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $this->seed(RoleSeeder::class);

        $this->policy = app(LessonPolicy::class);

        $this->enrollmentService = app(
            EnrollmentService::class
        );
    }

    public function test_enrolled_user_can_view_lesson(): void
    {
        $user = User::factory()->create();
        $lesson = $this->createLesson();

        $this->enrollmentService->enroll(
            $user,
            $lesson->section->course
        );

        $this->assertTrue(
            $this->policy->view($user, $lesson)
        );
    }

    public function test_unenrolled_user_cannot_view_lesson(): void
    {
        $user = User::factory()->create();
        $lesson = $this->createLesson();

        $this->assertFalse(
            $this->policy->view($user, $lesson)
        );
    }

    public function test_enrollment_in_another_course_does_not_grant_access(): void
    {
        $user = User::factory()->create();

        $accessibleCourse = Course::factory()->create();
        $restrictedLesson = $this->createLesson();

        $this->enrollmentService->enroll(
            $user,
            $accessibleCourse
        );

        $this->assertFalse(
            $this->policy->view($user, $restrictedLesson)
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