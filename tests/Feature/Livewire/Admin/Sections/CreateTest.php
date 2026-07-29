<?php

namespace Tests\Feature\Livewire\Admin\Sections;

use App\Livewire\Admin\Sections\Create;
use App\Models\Course;
use App\Models\Section;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $this->seed(RoleSeeder::class);
    }

    public function test_admin_can_open_create_page(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $course = Course::factory()->create();

        Livewire::actingAs($admin)
            ->test(Create::class, [
                'course' => $course,
            ])
            ->assertOk()
            ->assertSee('Новый раздел');
    }

    public function test_admin_can_create_section(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $course = Course::factory()->create();

        Livewire::actingAs($admin)
            ->test(Create::class, [
                'course' => $course,
            ])
            ->set('title', 'Введение')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('sections', [
            'course_id' => $course->id,
            'title' => 'Введение',
            'position' => 1,
        ]);
    }

    public function test_position_is_incremented(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $course = Course::factory()->create();

        Section::factory()->create([
            'course_id' => $course->id,
            'position' => 1,
        ]);

        Livewire::actingAs($admin)
            ->test(Create::class, [
                'course' => $course,
            ])
            ->set('title', 'Новый раздел')
            ->call('save');

        $this->assertDatabaseHas('sections', [
            'course_id' => $course->id,
            'title' => 'Новый раздел',
            'position' => 2,
        ]);
    }

    public function test_title_is_required(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $course = Course::factory()->create();

        Livewire::actingAs($admin)
            ->test(Create::class, [
                'course' => $course,
            ])
            ->set('title', '')
            ->call('save')
            ->assertHasErrors([
                'title' => 'required',
            ]);

        $this->assertDatabaseCount('sections', 0);
    }
}