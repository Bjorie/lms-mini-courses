<?php

namespace App\Livewire\Forms;

use App\Enums\CourseLevel;
use App\Enums\CourseStatus;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Form;


class CourseForm extends Form
{
    public ?Course $course = null;

    public string $title = '';

    public string $slug = '';

    public ?int $category_id = null;

    public ?string $short_description = null;

    public ?string $description = null;

    public float $price = 0;

    public string $level = 'beginner';

    public string $status = 'draft';

    public ?string $thumbnail = null;

    public function setCourse(Course $course): void
    {
        $this->course = $course;

        $this->title = $course->title;
        $this->slug = $course->slug;
        $this->category_id = $course->category_id;
        $this->short_description = $course->short_description;
        $this->description = $course->description;
        $this->price = (float) ($course->price ?? 0);
        $this->level = $course->level->value;
        $this->status = $course->status->value;
        $this->thumbnail = $course->thumbnail;
    }

    protected function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'min:5',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('courses', 'slug')
                    ->ignore($this->course),
            ],

            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'thumbnail' => [
                'nullable',
                'string',
                'max:255',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'level' => [
                'required',
                Rule::enum(CourseLevel::class),
            ],

            'status' => [
                'required',
                Rule::enum(CourseStatus::class),
            ]
        ];
    }

    public function generateSlug(): void
    {
        if ($this->slug === '') {
            $this->slug = Str::slug($this->title);
        }
    }
}