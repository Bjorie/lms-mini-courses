<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use Database\Seeders\Data\CourseCatalog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LessonSeeder extends Seeder
{
    /**
     * Заполнение таблицы уроков.
     */
    public function run(): void
    {
        foreach (CourseCatalog::courses() as $courseData) {
            $course = Course::query()
                ->where('slug', Str::slug($courseData['title']))
                ->first();

            if (! $course) {
                $this->command?->warn(
                    "Курс «{$courseData['title']}» не найден. Уроки пропущены."
                );

                continue;
            }

            foreach ($courseData['sections'] ?? [] as $sectionIndex => $sectionData) {
                $section = Section::query()
                    ->where('course_id', $course->id)
                    ->where('position', $sectionIndex + 1)
                    ->first();

                if (! $section) {
                    $this->command?->warn(
                        "Раздел «{$sectionData['title']}» курса «{$courseData['title']}» не найден."
                    );

                    continue;
                }

                foreach ($sectionData['lessons'] ?? [] as $lessonIndex => $lessonData) {
                    $slug = Str::slug($lessonData['title']);

                    Lesson::updateOrCreate(
                        [
                            'section_id' => $section->id,
                            'slug' => $slug,
                        ],
                        [
                            'title' => $lessonData['title'],
                            'content' => $lessonData['content'] ?? null,
                            'video_url' => $lessonData['video_url'] ?? null,
                            'duration' => $lessonData['duration'] ?? 0,
                            'position' => $lessonIndex + 1,
                            'type' => $lessonData['type'] ?? 'video',
                            'is_free' => $lessonData['is_free'] ?? false,
                            'published_at' => now(),
                        ]
                    );
                }
            }
        }

        $this->command?->info('Уроки успешно созданы.');
    }
}