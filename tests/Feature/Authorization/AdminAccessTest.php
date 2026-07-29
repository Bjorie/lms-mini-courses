<?php

namespace Tests\Feature\Authorization;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $this->seed(RoleSeeder::class);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $course = Course::factory()->create();

        $this->get(
            route('admin.courses.edit', $course)
        )->assertRedirect(
            route('login')
        );
    }

    public function test_student_cannot_access_admin_dashboard(): void
    {
        $student = User::factory()->create();
        $student->assignRole('student');

        $this->actingAs($student)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_student_cannot_edit_course(): void
    {
        $student = User::factory()->create();
        $student->assignRole('student');

        $course = Course::factory()->create();

        $this->actingAs($student)
            ->get(route('admin.courses.edit', $course))
            ->assertForbidden();
    }

    public function test_student_cannot_edit_section(): void
    {
        $student = User::factory()->create();
        $student->assignRole('student');

        $section = Section::factory()->create();

        $this->actingAs($student)
            ->get(route('admin.sections.edit', $section))
            ->assertForbidden();
    }

    public function test_student_cannot_edit_lesson(): void
    {
        $student = User::factory()->create();
        $student->assignRole('student');

        $lesson = Lesson::factory()->create();

        $this->actingAs($student)
            ->get(route('admin.lessons.edit', $lesson))
            ->assertForbidden();
    }

    public function test_admin_can_open_dashboard(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk();
    }

    public function test_admin_can_open_course_edit(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $course = Course::factory()->create();

        $this->actingAs($admin)
            ->get(route('admin.courses.edit', $course))
            ->assertOk();
    }

    public function test_admin_can_open_section_edit(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $section = Section::factory()->create();

        $this->actingAs($admin)
            ->get(route('admin.sections.edit', $section))
            ->assertOk();
    }

    public function test_admin_can_open_lesson_edit(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $lesson = Lesson::factory()->create();

        $this->actingAs($admin)
            ->get(route('admin.lessons.edit', $lesson))
            ->assertOk();
    }
}