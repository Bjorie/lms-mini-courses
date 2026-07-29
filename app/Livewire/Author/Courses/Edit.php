<?php

namespace App\Livewire\Author\Courses;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Livewire\Component;

class Edit extends Component
{
    use AuthorizesRequests;

    public Course $course;

    public string $title = '';

    public string $short_description = '';

    public string $description = '';

    public string $level = 'beginner';

    public string $status = 'draft';

    public int|string $category_id = '';

    public float $price = 0;

    public function mount(Course $course): void
    {
        $this->authorize('update', $course);

        $this->course = $course;

        $this->title = $course->title;
        $this->short_description = $course->short_description;
        $this->description = $course->description ?? '';
        $this->category_id = $course->category_id;
        $this->level = $course->level;
        $this->status = $course->published_at ? 'published' : 'draft';
        $this->price = (float) $course->price;
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'level' => ['required', 'in:beginner,intermediate,advanced'],
            'status' => ['required', 'in:draft,published'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function save()
    {
        $this->authorize('update', $this->course);

        $this->validate();

        $this->course->update([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'short_description' => $this->short_description,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'level' => $this->level,
            'status' => $this->status,
            'price' => $this->price,
            'published_at' => $this->status === 'published'
                ? ($this->course->published_at ?? now())
                : null,
        ]);

        session()->flash('success', 'Курс успешно обновлён.');

        return redirect()->route('author.courses.index');
    }

    public function render(): View
    {
        return view('livewire.author.courses.edit', [
            'categories' => Category::query()
                ->orderBy('name')
                ->get(),
        ]);
    }
}