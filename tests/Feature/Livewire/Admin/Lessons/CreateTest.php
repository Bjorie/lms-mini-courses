<?php

namespace Tests\Feature\Livewire\Admin\Lessons;

use App\Livewire\Admin\Lessons\Create;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
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

        $section = Section::factory()->create();

        Livewire::actingAs($admin)
            ->test(Create::class, [
                'section' => $section,
            ])
            ->assertOk()
            ->assertSee('Новый урок')
            ->assertSee($section->title);
    }

    public function test_section_is_set_when_component_mounts(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $section = Section::factory()->create();

        Livewire::actingAs($admin)
            ->test(Create::class, [
                'section' => $section,
            ])
            ->assertSet(
                'form.section_id',
                $section->id
            );
    }

    public function test_admin_can_create_lesson(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $section = Section::factory()->create();

        Livewire::actingAs($admin)
            ->test(Create::class, [
                'section' => $section,
            ])
            ->set('form.title', 'Введение в Laravel')
            ->set('form.slug', 'introduction-to-laravel')
            ->set('form.content', '<p>Контент урока</p>')
            ->set(
                'form.video_url',
                'https://example.com/video'
            )
            ->set('form.duration', 600)
            ->set('form.is_free', true)
            ->set('form.isPublished', true)
            ->call('save')
            ->assertHasNoErrors();

            $this->assertDatabaseHas('lessons', [
                'section_id' => $section->id,
                'title' => 'Введение в Laravel',
                'slug' => 'introduction-to-laravel',
                'content' => '<p>Контент урока</p>',
                'video_url' => 'https://example.com/video',
                'duration' => 600,
                'is_free' => true,
                'position' => 1,
            ]);

            $lesson = Lesson::query()
                ->where('section_id', $section->id)
                ->where('slug', 'introduction-to-laravel')
                ->firstOrFail();

            $this->assertNotNull($lesson->published_at);
    }

    public function test_slug_is_generated_when_empty(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $section = Section::factory()->create();

        $title = 'Основы Laravel';

        Livewire::actingAs($admin)
            ->test(Create::class, [
                'section' => $section,
            ])
            ->set('form.title', $title)
            ->set('form.slug', '')
            ->set('form.duration', 0)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('lessons', [
            'section_id' => $section->id,
            'title' => $title,
            'slug' => Str::slug($title),
        ]);
    }

    public function test_position_is_incremented(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $section = Section::factory()->create();

        Lesson::factory()->create([
            'section_id' => $section->id,
            'position' => 3,
        ]);

        Livewire::actingAs($admin)
            ->test(Create::class, [
                'section' => $section,
            ])
            ->set('form.title', 'Следующий урок')
            ->set('form.slug', 'next-lesson')
            ->set('form.duration', 0)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('lessons', [
            'section_id' => $section->id,
            'slug' => 'next-lesson',
            'position' => 4,
        ]);
    }

    public function test_same_slug_is_allowed_in_another_section(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $firstSection = Section::factory()->create();
        $secondSection = Section::factory()->create();

        Lesson::factory()->create([
            'section_id' => $firstSection->id,
            'slug' => 'introduction',
        ]);

        Livewire::actingAs($admin)
            ->test(Create::class, [
                'section' => $secondSection,
            ])
            ->set('form.title', 'Introduction')
            ->set('form.slug', 'introduction')
            ->set('form.duration', 0)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('lessons', [
            'section_id' => $secondSection->id,
            'slug' => 'introduction',
        ]);
    }

    public function test_slug_must_be_unique_inside_section(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $section = Section::factory()->create();

        Lesson::factory()->create([
            'section_id' => $section->id,
            'slug' => 'introduction',
        ]);

        Livewire::actingAs($admin)
            ->test(Create::class, [
                'section' => $section,
            ])
            ->set('form.title', 'Другой урок')
            ->set('form.slug', 'introduction')
            ->set('form.duration', 0)
            ->call('save')
            ->assertHasErrors([
                'form.slug' => 'unique',
            ]);

        $this->assertDatabaseCount('lessons', 1);
    }

    public function test_title_is_required(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $section = Section::factory()->create();

        Livewire::actingAs($admin)
            ->test(Create::class, [
                'section' => $section,
            ])
            ->set('form.title', '')
            ->set('form.slug', '')
            ->call('save')
            ->assertHasErrors([
                'form.title' => 'required',
            ]);

        $this->assertDatabaseCount('lessons', 0);
    }

    public function test_video_url_must_be_valid(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $section = Section::factory()->create();

        Livewire::actingAs($admin)
            ->test(Create::class, [
                'section' => $section,
            ])
            ->set('form.title', 'Видео урок')
            ->set('form.slug', 'video-lesson')
            ->set('form.video_url', 'not-a-url')
            ->set('form.duration', 100)
            ->call('save')
            ->assertHasErrors([
                'form.video_url' => 'url',
            ]);
    }

    public function test_duration_cannot_be_negative(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $section = Section::factory()->create();

        Livewire::actingAs($admin)
            ->test(Create::class, [
                'section' => $section,
            ])
            ->set('form.title', 'Новый урок')
            ->set('form.slug', 'new-lesson')
            ->set('form.duration', -1)
            ->call('save')
            ->assertHasErrors([
                'form.duration' => 'min',
            ]);
    }
}