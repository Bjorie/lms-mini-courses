<?php

namespace App\Services\Course;

use App\DTO\Course\CourseData;
use App\Enums\CourseStatus;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Carbon;

class CourseService
{
    public function create(
        CourseData $data,
        User $author,
    ): Course {
        return Course::query()->create([
            ...$this->attributes($data),
            'author_id' => $author->id,
            'published_at' => $this->publishedAt(
                null,
                $data,
            ),
        ]);
    }

    public function update(
        Course $course,
        CourseData $data,
    ): Course {
        $course->update([
            ...$this->attributes($data),
            'published_at' => $this->publishedAt(
                $course,
                $data,
            ),
        ]);

        return $course->refresh();
    }

    private function attributes(
        CourseData $data,
    ): array {
        return [
            'category_id' => $data->categoryId,
            'title' => $data->title,
            'slug' => $data->slug,
            'short_description' => $data->shortDescription,
            'description' => $data->description,
            'thumbnail' => $data->thumbnail,
            'price' => $data->price,
            'level' => $data->level,
            'status' => $data->status,
        ];
    }

    private function publishedAt(
        ?Course $course,
        CourseData $data,
    ): ?Carbon {
        if ($data->status !== CourseStatus::Published) {
            return null;
        }

        return $course?->published_at ?? now();
    }
}