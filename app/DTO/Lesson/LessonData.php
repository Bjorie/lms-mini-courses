<?php

namespace App\DTO\Lesson;

use App\Livewire\Forms\LessonForm;

final readonly class LessonData
{
    public function __construct(
        public int $sectionId,
        public string $title,
        public string $slug,
        public ?string $content,
        public ?string $videoUrl,
        public int $duration,
        public bool $isFree,
        public bool $isPublished,
    ) {
    }

    public static function fromForm(
        LessonForm $form,
    ): self {
        return new self(
            sectionId: $form->section_id,
            title: $form->title,
            slug: $form->slug,
            content: $form->content,
            videoUrl: $form->video_url,
            duration: $form->duration,
            isFree: $form->is_free,
            isPublished: $form->isPublished,
        );
    }
}