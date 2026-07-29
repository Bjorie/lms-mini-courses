<?php

namespace App\Livewire\Author\Courses;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public string $title = '';

    public string $short_description = '';

    public string $description = '';

    public string $level = 'beginner';

    public string $status = 'draft';

    public int|string $category_id = '';

    public float $price = 0;

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
        $this->validate();

        $course = Course::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'short_description' => $this->short_description,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'author_id' => auth()->id(),
            'level' => $this->level,
            'status' => $this->status,
            'price' => $this->price,
            'published_at' => $this->status === 'published'
                ? now()
                : null,
        ]);

        session()->flash('success', 'Курс успешно создан.');

        return redirect()->route('author.courses.index');
    }

    public function render(): View
    {
        return view('livewire.author.courses.create', [
            'categories' => Category::query()
                ->orderBy('name')
                ->get(),
        ]);
    }
}