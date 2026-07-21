<?php

namespace App\Livewire\Forms;

use App\Models\Course;
use Illuminate\Support\Str;
use Livewire\Form;
use Illuminate\Validation\Rule;

class CourseForm extends Form
{
    public ?Course $course = null;

    public string $title = '';
    public string $slug = '';
    public ?int $category_id = null;
    public ?string $short_description = '';
    public ?string $description = '';
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
                'exists:categories,id',
            ],

            'short_description' => [
                'nullable',
                'max:500',
            ],

            'description' => [
                'nullable',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'level' => [
                'required',
            ],

            'status' => [
                'required',
            ],
        ];
    }

public function store(): Course
{
    $this->validate();

    return Course::create([
        ...$this->data(),
        'author_id' => auth()->id(),
    ]);
}

    public function update(): void
    {
        $this->validate();

        $this->course->update($this->data());
    }

    protected function data(): array
    {
        return [

            'category_id' => $this->category_id,

            'title' => $this->title,

            'slug' => $this->slug ?: Str::slug($this->title),

            'short_description' => $this->short_description,

            'description' => $this->description,

            'thumbnail' => $this->thumbnail,

            'price' => $this->price,

            'level' => $this->level,

            'status' => $this->status,

        ];
    }


    
}
