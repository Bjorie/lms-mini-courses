<?php

namespace Tests\Feature\Livewire\Admin\Sections;

use App\Livewire\Admin\Sections\Edit;
use App\Models\Section;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $this->seed(RoleSeeder::class);
    }

    public function test_admin_can_open_edit_page(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $section = Section::factory()->create();

        Livewire::actingAs($admin)
            ->test(Edit::class, [
                'section' => $section,
            ])
            ->assertOk()
            ->assertSee('Редактировать раздел');
    }

    public function test_form_is_filled(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $section = Section::factory()->create([
            'title' => 'Laravel Basics',
        ]);

        Livewire::actingAs($admin)
            ->test(Edit::class, [
                'section' => $section,
            ])
            ->assertSet('title', 'Laravel Basics');
    }

    public function test_admin_can_update_section(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $section = Section::factory()->create();

        Livewire::actingAs($admin)
            ->test(Edit::class, [
                'section' => $section,
            ])
            ->set('title', 'Обновлённый раздел')
            ->call('save')
            ->assertHasNoErrors();

        $section->refresh();

        $this->assertSame(
            'Обновлённый раздел',
            $section->title
        );
    }

    public function test_title_is_required(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $section = Section::factory()->create();

        Livewire::actingAs($admin)
            ->test(Edit::class, [
                'section' => $section,
            ])
            ->set('title', '')
            ->call('save')
            ->assertHasErrors([
                'title' => 'required',
            ]);
    }
}