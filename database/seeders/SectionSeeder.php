<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Section;
use Database\Seeders\Data\CourseCatalog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SectionSeeder extends Seeder
{
    /**
     * Заполнение таблицы разделов курсов.
     */
    public function run(): void
    {
        foreach (CourseCatalog::courses() as $courseData) {
            $course = Course::query()
                ->where('slug', Str::slug($courseData['title']))
                ->first();

            if (! $course) {
                $this->command?->warn(
                    "Курс «{$courseData['title']}» не найден. Разделы пропущены."
                );

                continue;
            }

            foreach ($courseData['sections'] ?? [] as $index => $sectionData) {
                Section::updateOrCreate(
                    [
                        'course_id' => $course->id,
                        'position' => $index + 1,
                    ],
                    [
                        'title' => $sectionData['title'],
                    ]
                );
            }
        }

        $this->command?->info('Разделы курсов успешно созданы.');
    }
}