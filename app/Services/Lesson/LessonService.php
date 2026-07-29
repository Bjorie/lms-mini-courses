<?php

namespace App\Services\Lesson;

use App\DTO\Lesson\LessonData;
use App\Models\Lesson;
use Illuminate\Support\Carbon;

class LessonService
{
    public function create(
        LessonData $data
    ): Lesson {
        return Lesson::query()->create([
            ...$this->attributes($data),

            'position' => $this->nextPosition(
                $data->sectionId
            ),

            'published_at' => $data->isPublished
                ? now()
                : null,
        ]);
    }

    public function update(
        Lesson $lesson,
        LessonData $data
    ): Lesson {
        $lesson->update([
            ...$this->attributes($data),

            'published_at' => $this->publishedAt(
                $lesson,
                $data
            ),
        ]);

        return $lesson->refresh();
    }

    private function attributes(
        LessonData $data
    ): array {
        return [
            'section_id' => $data->sectionId,
            'title' => $data->title,
            'slug' => $data->slug,
            'content' => $data->content,
            'video_url' => $data->videoUrl,
            'duration' => $data->duration,
            'is_free' => $data->isFree,
        ];
    }

    private function publishedAt(
        Lesson $lesson,
        LessonData $data,
    ): ?Carbon {
        if (! $data->isPublished) {
            return null;
        }

        return $lesson->published_at ?? now();
    }

    private function nextPosition(
        int $sectionId
    ): int {
        $lastPosition = Lesson::query()
            ->where('section_id', $sectionId)
            ->max('position');

        return ($lastPosition ?? 0) + 1;
    }
}