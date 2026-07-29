<?php

namespace App\Livewire\Forms;

use App\Models\Lesson;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Form;

class LessonForm extends Form
{
    public ?Lesson $lesson = null;

    public ?int $section_id = null;

    public string $title = '';

    public string $slug = '';

    public string $content = '';

    public ?string $video_url = null;

    public int $duration = 5;

    public int $position = 1;

    public string $type = 'video';

    public bool $is_free = false;

    public bool $isPublished = false;

    protected function rules(): array
    {
        $slugRule = Rule::unique('lessons', 'slug')
            ->where(
                fn (Builder $query): Builder => $query->where(
                    'section_id',
                    $this->section_id
                )
            );

        if ($this->lesson !== null) {
            $slugRule->ignore($this->lesson->id);
        }

        return [
            'section_id' => [
                'required',
                'integer',
                'exists:sections,id',
            ],
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'slug' => [
                'required',
                'string',
                'max:255',
                $slugRule,
            ],
            'content' => [
                'nullable',
                'string',
            ],
            'video_url' => [
                'nullable',
                'url',
            ],
            'duration' => [
                'required',
                'integer',
                'min:0',
            ],
            'position' => [
                'required',
                'integer',
                'min:1',
            ],
            'type' => [
                'required',
                Rule::in([
                    'video',
                    'text',
                    'quiz',
                    'file',
                ]),
            ],
            'is_free' => [
                'boolean',
            ],
            'isPublished' => [
                'boolean',
            ],
        ];
    }

    public function updatedTitle(): void
    {
        if ($this->lesson === null || blank($this->slug)) {
            $this->generateSlug();
        }
    }

    public function generateSlug(): void
    {
        if (blank($this->slug)) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function setLesson(Lesson $lesson): void
    {
        $this->lesson = $lesson;

        $this->section_id = $lesson->section_id;
        $this->title = $lesson->title;
        $this->slug = $lesson->slug;
        $this->content = $lesson->content ?? '';
        $this->video_url = $lesson->video_url;
        $this->duration = $lesson->duration;
        $this->position = $lesson->position;
        $this->type = $lesson->type;
        $this->is_free = $lesson->is_free;
        $this->isPublished = $lesson->published_at !== null;
    }

    public function store(): Lesson
    {
        $this->validate();

        $lesson = Lesson::create([
            'section_id' => $this->section_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'video_url' => $this->video_url,
            'duration' => $this->duration,
            'position' => $this->position,
            'type' => $this->type,
            'is_free' => $this->is_free,
            'published_at' => $this->isPublished ? now() : null,
        ]);

        $this->lesson = $lesson;

        return $lesson;
    }

    public function update(): void
    {
        if ($this->lesson === null) {
            return;
        }

        $this->validate();

        $this->lesson->update([
            'section_id' => $this->section_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'video_url' => $this->video_url,
            'duration' => $this->duration,
            'position' => $this->position,
            'type' => $this->type,
            'is_free' => $this->is_free,
            'published_at' => $this->isPublished
                ? ($this->lesson->published_at ?? now())
                : null,
        ]);
    }

    public function resetForm(): void
    {
        $this->reset();

        $this->lesson = null;
        $this->section_id = null;
        $this->title = '';
        $this->slug = '';
        $this->content = '';
        $this->video_url = null;
        $this->duration = 5;
        $this->position = 1;
        $this->type = 'video';
        $this->is_free = false;
        $this->isPublished = false;
    }
}