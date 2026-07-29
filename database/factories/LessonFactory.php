<?php

namespace Database\Factories;

use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'section_id' => Section::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 9999),
            'content' => fake()->paragraphs(3, true),
            'video_url' => fake()->url(),
            'duration' => fake()->numberBetween(300, 3600),
            'position' => 1,
            'is_free' => fake()->boolean(),
            'published_at' => now(),
            'type' => 'video'
        ];
    }
}