<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Database\Seeders\Data\CourseCatalog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Заполнение таблицы курсов.
     */
    public function run(): void
    {
        $author = User::role('admin')->first();

        if (! $author) {
            $this->command?->warn(
                'Администратор не найден. Сначала выполните AdminSeeder.'
            );

            return;
        }

        foreach (CourseCatalog::courses() as $courseData) {
            $category = Category::query()
                ->where('name', $courseData['category'])
                ->first();

            if (! $category) {
                $this->command?->warn(
                    "Категория «{$courseData['category']}» не найдена. Курс «{$courseData['title']}» пропущен."
                );

                continue;
            }

            Course::updateOrCreate(
                [
                    'slug' => Str::slug($courseData['title']),
                ],
                [
                    'title' => $courseData['title'],
                    'short_description' => $courseData['short_description'],
                    'description' => $courseData['description'],
                    'category_id' => $category->id,
                    'author_id' => $author->id,
                    'level' => $courseData['level'] ?? 'beginner',
                    'status' => $courseData['status'] ?? 'published',
                    'price' => $courseData['price'] ?? 0,
                    'published_at' => now(),
                ]
            );
        }

        $this->command?->info('Курсы успешно созданы.');
    }
}