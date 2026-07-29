<?php

namespace App\DTO\Course;

use App\Enums\CourseLevel;
use App\Enums\CourseStatus;
use App\Livewire\Forms\CourseForm;

readonly class CourseData
{
    public function __construct(
        public int $categoryId,
        public string $title,
        public string $slug,
        public ?string $shortDescription,
        public ?string $description,
        public ?string $thumbnail,
        public float $price,
        public CourseLevel $level,
        public CourseStatus $status,
    ) {
    }

    public static function fromForm(
        CourseForm $form,
    ): self {
        return new self(
            categoryId: $form->category_id,
            title: $form->title,
            slug: $form->slug,
            shortDescription: $form->short_description,
            description: $form->description,
            thumbnail: $form->thumbnail,
            price: $form->price,
            level: CourseLevel::from($form->level),
            status: CourseStatus::from($form->status),
        );
    }
}