<?php

namespace Tests\Feature\Livewire\Admin\Courses;

use App\Livewire\Admin\Courses\Create;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;
use Illuminate\Support\Str;

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

        Livewire::actingAs($admin)
            ->test(Create::class)
            ->assertOk()
            ->assertSee('Создать курс');
    }

    public function test_slug_is_generated_from_title(): void
    {
        $admin = User::factory()->create();

        $admin->assignRole('admin');

        $title = 'Laravel для начинающих';

        Livewire::actingAs($admin)
            ->test(Create::class)
            ->set('form.title', $title)
            ->assertSet(
                'form.slug',
                Str::slug($title)
            );
    }

    public function test_manual_slug_is_not_overwritten(): void
    {
        $admin = User::factory()->create();

        $admin->assignRole('admin');

        Livewire::actingAs($admin)
            ->test(Create::class)
            ->set('form.slug', 'my-course')
            ->set('form.title', 'Совсем другое название')
            ->assertSet(
                'form.slug',
                'my-course'
            );
    }

    public function test_admin_can_create_course(): void
    {
        $admin = User::factory()->create();
        $category = Category::factory()->create();

        $admin->assignRole('admin');

        Livewire::actingAs($admin)
            ->test(Create::class)
            ->set('form.title', 'Laravel для начинающих')
            ->set('form.slug', 'laravel-dlya-nachinayushchih')
            ->set('form.category_id', $category->id)
            ->set('form.short_description', 'Краткое описание курса')
            ->set('form.description', 'Полное описание курса')
            ->set('form.price', 49.99)
            ->set('form.level', 'beginner')
            ->set('form.status', 'draft')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('courses', [
            'author_id' => $admin->id,
            'category_id' => $category->id,
            'title' => 'Laravel для начинающих',
            'slug' => 'laravel-dlya-nachinayushchih',
            'short_description' => 'Краткое описание курса',
            'description' => 'Полное описание курса',
            'price' => 49.99,
            'level' => 'beginner',
            'status' => 'draft',
        ]);
    }

    public function test_slug_is_generated_when_it_is_empty(): void
    {
        $admin = User::factory()->create();
        $category = Category::factory()->create();

        $admin->assignRole('admin');

        Livewire::actingAs($admin)
            ->test(Create::class)
            ->set('form.title', 'Продвинутый курс Laravel')
            ->set('form.slug', '')
            ->set('form.category_id', $category->id)
            ->set('form.price', 0)
            ->set('form.level', 'advanced')
            ->set('form.status', 'draft')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('courses', [
            'author_id' => $admin->id,
            'title' => 'Продвинутый курс Laravel',
            'slug' => Str::slug('Продвинутый курс Laravel'),
        ]);
    }

    public function test_title_is_required(): void
    {
        $admin = User::factory()->create();
        $category = Category::factory()->create();

        $admin->assignRole('admin');

        Livewire::actingAs($admin)
            ->test(Create::class)
            ->set('form.title', '')
            ->set('form.slug', '')
            ->set('form.category_id', $category->id)
            ->call('save')
            ->assertHasErrors([
                'form.title' => 'required',
            ]);

        $this->assertDatabaseCount('courses', 0);
    }

    public function test_category_is_required(): void
    {
        $admin = User::factory()->create();

        $admin->assignRole('admin');

        Livewire::actingAs($admin)
            ->test(Create::class)
            ->set('form.title', 'Новый курс Laravel')
            ->set('form.slug', 'novyi-kurs-laravel')
            ->set('form.category_id', null)
            ->call('save')
            ->assertHasErrors([
                'form.category_id' => 'required',
            ]);

        $this->assertDatabaseCount('courses', 0);
    }

    public function test_category_must_exist(): void
    {
        $admin = User::factory()->create();

        $admin->assignRole('admin');

        Livewire::actingAs($admin)
            ->test(Create::class)
            ->set('form.title', 'Новый курс Laravel')
            ->set('form.slug', 'novyi-kurs-laravel')
            ->set('form.category_id', 999999)
            ->call('save')
            ->assertHasErrors([
                'form.category_id' => 'exists',
            ]);

        $this->assertDatabaseCount('courses', 0);
    }    

    public function test_slug_must_be_unique(): void
    {
        $admin = User::factory()->create();
        $category = Category::factory()->create();

        $admin->assignRole('admin');

        Course::factory()->create([
            'slug' => 'laravel-course',
        ]);

        Livewire::actingAs($admin)
            ->test(Create::class)
            ->set('form.title', 'Ещё один Laravel курс')
            ->set('form.slug', 'laravel-course')
            ->set('form.category_id', $category->id)
            ->call('save')
            ->assertHasErrors([
                'form.slug' => 'unique',
            ]);

        $this->assertDatabaseCount('courses', 1);
    }

    public function test_price_cannot_be_negative(): void
    {
        $admin = User::factory()->create();
        $category = Category::factory()->create();

        $admin->assignRole('admin');

        Livewire::actingAs($admin)
            ->test(Create::class)
            ->set('form.title', 'Платный Laravel курс')
            ->set('form.slug', 'paid-laravel-course')
            ->set('form.category_id', $category->id)
            ->set('form.price', -10)
            ->call('save')
            ->assertHasErrors([
                'form.price' => 'min',
            ]);

        $this->assertDatabaseCount('courses', 0);
    }

}