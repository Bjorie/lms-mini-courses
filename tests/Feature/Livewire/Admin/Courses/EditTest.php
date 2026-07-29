<?php

namespace Tests\Feature\Livewire\Admin\Courses;

use App\Livewire\Admin\Courses\Edit;
use App\Models\Category;
use App\Models\Course;
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

        $course = Course::factory()->create();

        Livewire::actingAs($admin)
            ->test(Edit::class, [
                'course' => $course,
            ])
            ->assertOk()
            ->assertSee('Редактировать курс');
    }

    public function test_form_is_filled_from_course(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $course = Course::factory()->create([
            'title' => 'Laravel 13',
            'slug' => 'laravel-13',
            'price' => 99,
        ]);

        Livewire::actingAs($admin)
            ->test(Edit::class, [
                'course' => $course,
            ])
            ->assertSet('form.title', 'Laravel 13')
            ->assertSet('form.slug', 'laravel-13')
            ->assertSet('form.price', 99);
    }

    public function test_admin_can_update_course(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $category = Category::factory()->create();

        $course = Course::factory()->create();

        Livewire::actingAs($admin)
            ->test(Edit::class, [
                'course' => $course,
            ])
            ->set('form.title', 'Новый заголовок')
            ->set('form.slug', 'novyi-zagolovok')
            ->set('form.category_id', $category->id)
            ->set('form.short_description', 'Новое краткое описание')
            ->set('form.description', 'Новое полное описание')
            ->set('form.price', 150)
            ->call('save')
            ->assertHasNoErrors();

        $course->refresh();

        $this->assertSame(
            'Новый заголовок',
            $course->title
        );

        $this->assertSame(
            'novyi-zagolovok',
            $course->slug
        );

        $this->assertSame(
            150.0,
            (float) $course->price
        );

        $this->assertSame(
            $category->id,
            $course->category_id
        );
    }

    public function test_current_slug_is_allowed(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $course = Course::factory()->create([
            'slug' => 'laravel-course',
        ]);

        Livewire::actingAs($admin)
            ->test(Edit::class, [
                'course' => $course,
            ])
            ->set('form.title', 'Laravel Course Updated')
            ->set('form.slug', 'laravel-course')
            ->call('save')
            ->assertHasNoErrors();
    }

    public function test_slug_must_be_unique_for_other_courses(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        Course::factory()->create([
            'slug' => 'existing-slug',
        ]);

        $course = Course::factory()->create();

        Livewire::actingAs($admin)
            ->test(Edit::class, [
                'course' => $course,
            ])
            ->set('form.slug', 'existing-slug')
            ->call('save')
            ->assertHasErrors([
                'form.slug' => 'unique',
            ]);
    }

    public function test_title_is_required(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $course = Course::factory()->create();

        Livewire::actingAs($admin)
            ->test(Edit::class, [
                'course' => $course,
            ])
            ->set('form.title', '')
            ->call('save')
            ->assertHasErrors([
                'form.title' => 'required',
            ]);
    }
}