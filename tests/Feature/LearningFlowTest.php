<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\User;
use App\Services\Enrollment\EnrollmentService;
use App\Services\LessonProgress\LessonProgressService;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class LearningFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $this->seed(RoleSeeder::class);
    }

    public function test_student_can_complete_entire_course(): void
    {
        $student = User::factory()->create();
        $student->assignRole('student');

        $course = Course::factory()->create([
            'status' => 'published',
        ]);

        $section = Section::factory()->create([
            'course_id' => $course->id,
            'position' => 1,
        ]);

        $firstLesson = Lesson::factory()->create([
            'section_id' => $section->id,
            'position' => 1,
            'published_at' => now(),
        ]);

        $secondLesson = Lesson::factory()->create([
            'section_id' => $section->id,
            'position' => 2,
            'published_at' => now(),
        ]);

        $enrollmentService = app(
            EnrollmentService::class
        );

        $progressService = app(
            LessonProgressService::class
        );

        $enrollmentService->enroll(
            $student,
            $course
        );

        $this->assertTrue(
            $enrollmentService->isEnrolled(
                $student,
                $course
            )
        );

        $this->assertFalse(
            $progressService->isCourseCompleted(
                $student,
                $course
            )
        );

        $progressService->complete(
            $student,
            $firstLesson
        );

        $this->assertTrue(
            $progressService->isCompleted(
                $student,
                $firstLesson
            )
        );

        $this->assertFalse(
            $progressService->isCourseCompleted(
                $student,
                $course
            )
        );

        $progressService->complete(
            $student,
            $secondLesson
        );

        $this->assertTrue(
            $progressService->isCompleted(
                $student,
                $secondLesson
            )
        );

        $this->assertTrue(
            $progressService->isCourseCompleted(
                $student,
                $course
            )
        );
    }
}