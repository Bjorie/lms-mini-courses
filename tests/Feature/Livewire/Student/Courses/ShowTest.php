<?php

namespace Tests\Feature\Livewire\Student\Courses;

use App\Livewire\Student\Courses\Show;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\User;
use App\Services\Enrollment\EnrollmentService;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    private EnrollmentService $enrollmentService;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $this->seed(RoleSeeder::class);

        $this->enrollmentService = app(
            EnrollmentService::class
        );
    }

    public function test_guest_can_open_course_page(): void
    {
        $course = Course::factory()->create();

        Livewire::test(Show::class, [
            'course' => $course,
        ])
            ->assertOk()
            ->assertSee($course->title);
    }

    public function test_student_can_open_course_page(): void
    {
        $student = User::factory()->create();

        $student->assignRole('student');

        $course = Course::factory()->create();

        Livewire::actingAs($student)
            ->test(Show::class, [
                'course' => $course,
            ])
            ->assertOk()
            ->assertSee($course->title);
    }

    public function test_student_can_enroll(): void
    {
        $student = User::factory()->create();

        $student->assignRole('student');

        $course = Course::factory()->create();

        Livewire::actingAs($student)
            ->test(Show::class, [
                'course' => $course,
            ])
            ->call('enroll');

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $student->id,
            'course_id' => $course->id,
        ]);
    }

    public function test_progress_is_zero_after_enrollment(): void
    {
        $student = User::factory()->create();

        $student->assignRole('student');

        $course = Course::factory()->create();

        Livewire::actingAs($student)
            ->test(Show::class, [
                'course' => $course,
            ])
            ->call('enroll')
            ->assertSet('progressPercentage', 0);
    }

    public function test_first_lesson_is_detected(): void
    {
        $course = Course::factory()->create();

        $section = Section::factory()
            ->for($course)
            ->create();

        $lesson = Lesson::factory()
            ->for($section)
            ->create([
                'position' => 1,
            ]);

        Livewire::test(Show::class, [
            'course' => $course,
        ])
            ->assertSet(
                'firstLesson.id',
                $lesson->id
            );
    }

    public function test_component_knows_student_is_enrolled(): void
    {
        $student = User::factory()->create();

        $student->assignRole('student');

        $course = Course::factory()->create();

        $this->enrollmentService->enroll(
            $student,
            $course
        );

        Livewire::actingAs($student)
            ->test(Show::class, [
                'course' => $course,
            ])
            ->assertSee('Прогресс курса')
            ->assertSee('В этом курсе пока нет уроков.')
            ->assertDontSee('Записаться на курс');
    }

    public function test_enrolled_student_sees_learning_link(): void
    {
        $student = User::factory()->create();
        $course = Course::factory()->create();

        $section = Section::factory()
            ->for($course)
            ->create();

        Lesson::factory()
            ->for($section)
            ->create();

        $student->assignRole('student');

        $this->enrollmentService->enroll(
            $student,
            $course
        );

        Livewire::actingAs($student)
            ->test(Show::class, [
                'course' => $course,
            ])
            ->assertSee('Перейти к обучению');
    }

}