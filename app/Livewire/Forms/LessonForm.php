<?php

namespace App\Livewire\Forms;

use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Support\Str;
use Livewire\Form;
use Illuminate\Validation\Rule;
class LessonForm extends Form
{
    public ?Lesson $lesson = null;
    public ?int $section_id = null;
    public string $title = '';
    public string $slug = '';
    public ?string $content = null;
    public ?string $video_url = null;
    public int $duration = 0;
    public bool $is_free = false;
    public bool $is_published = false;

    protected function data(): array
    {
        return [
            'section_id' => $this->section_id,
            'title' => $this->title,
            'slug' => blank($this->slug)
                ? Str::slug($this->title)
                : $this->slug,
            'content' => $this->content,
            'video_url' => $this->video_url,
            'duration' => $this->duration,
            'is_free' => $this->is_free,
            'position' => $this->lesson
                ? $this->lesson->position
                : $this->nextPosition(),
            'is_published' => $this->is_published,
            'published_at' => $this->is_published
                ? ($this->lesson?->published_at ?? now())
                : null
        ];
    }

    public function resetForm(): void
    {
        $this->reset();
        $this->lesson = null;
        $this->section_id = null;
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
        $this->content = $lesson->content;
        $this->video_url = $lesson->video_url;
        $this->duration = $lesson->duration;
        $this->is_free = $lesson->is_free;
        $this->is_published = $lesson->is_published;
    }
    public function store(): Lesson
    {

        $this->generateSlug();
        $this->validate();

        return Lesson::create($this->data());
    }
    public function update(): void
    {
        $this->generateSlug();
        $this->validate();

        $this->lesson->update(
            $this->data()
        );
    }    
    protected function nextPosition(): int
    {
        return (Lesson::where(
            'section_id',
            $this->section_id
        )->max('position') ?? 0) + 1;
    }    
    protected function rules(): array
    {
        return [
            'section_id' => ['required', 'exists:sections,id'],

            'title' => ['required', 'min:3', 'max:255'],

            'slug' => [
                        'required',
                        'string',
                        'max:255',

                        Rule::unique('lessons')
                            ->where(fn ($query) => $query->where(
                                'section_id',
                                $this->section_id
                            ))
                            ->ignore($this->lesson),
            ],

            'content' => ['nullable'],

            'video_url' => ['nullable', 'url'],

            'duration' => ['required', 'integer', 'min:0'],
        ];
    }


}
