<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);

        return [

            'author_id' => User::role('admin')->first()?->id ?? User::first()->id,

            'category_id' => Category::inRandomOrder()->first()->id,

            'title' => $title,

            'slug' => Str::slug($title),

            'short_description' => fake()->sentence(),

            'description' => fake()->paragraphs(5, true),

            'thumbnail' => null,

            'price' => fake()->randomFloat(2, 0, 199),

            'level' => fake()->randomElement([
                'beginner',
                'intermediate',
                'advanced'
            ]),

            'status' => fake()->randomElement([
                'draft',
                'review',
                'published'
            ]),

            'published_at' => now(),

        ];
    }
}
