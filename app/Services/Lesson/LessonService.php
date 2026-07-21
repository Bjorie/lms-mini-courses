<?php

namespace App\Services\Lesson;

use App\DTO\Lesson\UpdateLessonData;
use App\Models\Lesson;

class LessonService
{
    public function create(UpdateLessonData $data): Lesson
    {
        return Lesson::create([
            'section_id' => $data->sectionId,
            'title' => $data->title,
            'slug' => $data->slug,
            'content' => $data->content,
            'video_url' => $data->videoUrl,
            'duration' => $data->duration,
            'is_free' => $data->isFree,
            'position' => (
                Lesson::where('section_id', $data->sectionId)
                    ->max('position') ?? 0
            ) + 1,
            'is_published' => $data->isPublished,
            'published_at' => $data->isPublished
                ? now()
                : null,
        ]);
    }

    public function update(
        Lesson $lesson,
        UpdateLessonData $data
    ): Lesson {

        $lesson->update([

            'section_id' => $data->sectionId,
            'title' => $data->title,
            'slug' => $data->slug,
            'content' => $data->content,
            'video_url' => $data->videoUrl,
            'duration' => $data->duration,
            'is_free' => $data->isFree,
            'is_published' => $data->isPublished,
            'published_at' => $data->isPublished
                ? ($lesson->published_at ?? now())
                : null,

        ]);

        return $lesson;
    }

    public function delete(Lesson $lesson): void
    {
        $lesson->delete();
    }
}