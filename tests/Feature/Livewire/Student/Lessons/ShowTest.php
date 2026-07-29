<?php

namespace Tests\Feature\Livewire\Student\Lessons;

use App\Livewire\Student\Lessons\Show;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
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

    public function test_enrolled_student_can_open_lesson_component(): void
    {
        $student = User::factory()->create();
        $lesson = $this->createLesson();

        $student->assignRole('student');

        $this->enrollmentService->enroll(
            $student,
            $lesson->section->course,
        );

        Livewire::actingAs($student)
            ->test(Show::class, [
                'lesson' => $lesson,
            ])
            ->assertOk()
            ->assertSet('lesson.id', $lesson->id);
    }

    public function test_unenrolled_student_cannot_open_lesson_component(): void
    {
        $student = User::factory()->create();
        $lesson = $this->createLesson();

        $student->assignRole('student');

        Livewire::actingAs($student)
            ->test(Show::class, [
                'lesson' => $lesson,
            ])
            ->assertForbidden();
    }

    public function test_student_can_complete_lesson(): void
    {
        $student = User::factory()->create();
        $lesson = $this->createLesson();

        $student->assignRole('student');

        $this->enrollmentService->enroll(
            $student,
            $lesson->section->course,
        );

        Livewire::actingAs($student)
            ->test(Show::class, [
                'lesson' => $lesson,
            ])
            ->call('complete')
            ->assertSet('isCompleted', true)
            ->assertSet('progressPercentage', 100);

        $this->assertDatabaseHas('lesson_progress', [
            'user_id' => $student->id,
            'lesson_id' => $lesson->id,
        ]);
    }

    public function test_completing_lesson_twice_does_not_create_duplicate_progress(): void
    {
        $student = User::factory()->create();
        $lesson = $this->createLesson();

        $student->assignRole('student');

        $this->enrollmentService->enroll(
            $student,
            $lesson->section->course,
        );

        Livewire::actingAs($student)
            ->test(Show::class, [
                'lesson' => $lesson,
            ])
            ->call('complete')
            ->call('complete');

        $this->assertDatabaseCount('lesson_progress', 1);
    }

    public function test_component_detects_completed_lesson(): void
    {
        $student = User::factory()->create();
        $lesson = $this->createLesson();

        $student->assignRole('student');

        $this->enrollmentService->enroll(
            $student,
            $lesson->section->course,
        );

        LessonProgress::query()->create([
            'user_id' => $student->id,
            'lesson_id' => $lesson->id,
            'completed_at' => now(),
        ]);

        Livewire::actingAs($student)
            ->test(Show::class, [
                'lesson' => $lesson,
            ])
            ->assertSet('isCompleted', true)
            ->assertSet('progressPercentage', 100);
    }

    public function test_component_determines_previous_and_next_lessons(): void
    {
        $student = User::factory()->create();

        $course = Course::factory()->create();

        $section = Section::factory()
            ->for($course)
            ->create();

        $firstLesson = Lesson::factory()
            ->for($section)
            ->create([
                'position' => 1,
            ]);

        $currentLesson = Lesson::factory()
            ->for($section)
            ->create([
                'position' => 2,
            ]);

        $nextLesson = Lesson::factory()
            ->for($section)
            ->create([
                'position' => 3,
            ]);

        $student->assignRole('student');

        $this->enrollmentService->enroll(
            $student,
            $course,
        );

        Livewire::actingAs($student)
            ->test(Show::class, [
                'lesson' => $currentLesson,
            ])
            ->assertSet('previousLesson.id', $firstLesson->id)
            ->assertSet('nextLesson.id', $nextLesson->id);
    }

    public function test_progress_percentage_updates_after_completing_lesson(): void
    {
        $student = User::factory()->create();

        $course = Course::factory()->create();

        $section = Section::factory()
            ->for($course)
            ->create();

        $firstLesson = Lesson::factory()
            ->for($section)
            ->create([
                'position' => 1,
            ]);

        Lesson::factory()
            ->for($section)
            ->create([
                'position' => 2,
            ]);

        $student->assignRole('student');

        $this->enrollmentService->enroll(
            $student,
            $course,
        );

        Livewire::actingAs($student)
            ->test(Show::class, [
                'lesson' => $firstLesson,
            ])
            ->assertSet('progressPercentage', 0)
            ->call('complete')
            ->assertSet('isCompleted', true)
            ->assertSet('progressPercentage', 50);

        $this->assertDatabaseHas('lesson_progress', [
            'user_id' => $student->id,
            'lesson_id' => $firstLesson->id,
        ]);
    }

    public function test_completing_last_lesson_completes_course(): void
    {
        $student = User::factory()->create();

        $course = Course::factory()->create();

        $section = Section::factory()
            ->for($course)
            ->create();

        $firstLesson = Lesson::factory()
            ->for($section)
            ->create([
                'position' => 1,
            ]);

        $lastLesson = Lesson::factory()
            ->for($section)
            ->create([
                'position' => 2,
            ]);

        $student->assignRole('student');

        $this->enrollmentService->enroll(
            $student,
            $course,
        );

        LessonProgress::query()->create([
            'user_id' => $student->id,
            'lesson_id' => $firstLesson->id,
            'completed_at' => now(),
        ]);

        Livewire::actingAs($student)
            ->test(Show::class, [
                'lesson' => $lastLesson,
            ])
            ->assertSet('progressPercentage', 50)
            ->assertSet('nextLesson', null)
            ->call('complete')
            ->assertSet('isCompleted', true)
            ->assertSet('progressPercentage', 100)
            ->assertSet('nextLesson', null)
            ->assertSee('Поздравляем');

        $this->assertDatabaseHas('lesson_progress', [
            'user_id' => $student->id,
            'lesson_id' => $lastLesson->id,
        ]);

        $enrollment = Enrollment::query()
            ->where('user_id', $student->id)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $this->assertNotNull(
            $enrollment->completed_at
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