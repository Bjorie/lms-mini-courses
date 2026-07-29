<?php

namespace Tests\Feature\Regression;

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
use App\Enums\CourseStatus;

class CourseLifecycleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $this->seed(RoleSeeder::class);
    }

    public function test_complete_course_lifecycle(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $student = User::factory()->create();
        $student->assignRole('student');

        $course = Course::factory()->create([
            'status' => CourseStatus::Draft,
        ]);

        $section = Section::factory()->create([
            'course_id' => $course->id,
            'position' => 1,
        ]);

        $lessons = Lesson::factory()
            ->count(3)
            ->sequence(
                ['position' => 1],
                ['position' => 2],
                ['position' => 3],
            )
            ->create([
                'section_id' => $section->id,
                'published_at' => now(),
            ]);

            $course->update([
                'status' => CourseStatus::Published,
            ]);

        $this->assertSame(CourseStatus::Published,$course->fresh()->status);

        $enrollment = app(EnrollmentService::class);
        $progress = app(LessonProgressService::class);

        $enrollment->enroll($student, $course);

        $this->assertTrue(
            $enrollment->isEnrolled($student, $course)
        );

        foreach ($lessons as $lesson) {
            $progress->complete($student, $lesson);
        }

        $this->assertTrue(
            $progress->isCourseCompleted($student, $course)
        );
    }
}