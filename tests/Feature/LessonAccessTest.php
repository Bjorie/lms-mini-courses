<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\User;
use App\Services\Enrollment\EnrollmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LessonAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::findOrCreate('admin');
        Role::findOrCreate('student');
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $lesson = Lesson::factory()
            ->for(
                Section::factory()->for(Course::factory())
            )
            ->create();

        $this->get(route('student.lessons.show', $lesson))
            ->assertRedirect(route('login'));
    }

    public function test_student_without_enrollment_cannot_open_lesson(): void
    {
        $student = User::factory()->create();
        $student->assignRole('student');

        $lesson = Lesson::factory()
            ->for(
                Section::factory()->for(Course::factory())
            )
            ->create();

        $this->actingAs($student)
            ->get(route('student.lessons.show', $lesson))
            ->assertForbidden();
    }

    public function test_enrolled_student_can_open_lesson(): void
    {
        $student = User::factory()->create();
        $student->assignRole('student');

        $course = Course::factory()->create();

        $lesson = Lesson::factory()
            ->for(
                Section::factory()->for($course)
            )
            ->create();

        app(EnrollmentService::class)
            ->enroll($student, $course);

        $this->actingAs($student)
            ->get(route('student.lessons.show', $lesson))
            ->assertOk();
    }
}