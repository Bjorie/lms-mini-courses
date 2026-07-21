<?php

namespace App\Livewire\Admin\Courses;

use App\Enums\CourseLevel;
use App\Enums\CourseStatus;
use App\Livewire\Forms\CourseForm;
use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;

class Create extends Component
{
    public CourseForm $form;
    public bool $slugLocked = false;

    public function save()
    {
        $this->form->store();

        session()->flash(
            'success',
            'Курс успешно создан.'
        );

        return redirect()->route('admin.courses.index');
    }

    public function updatedFormSlug(): void
    {
        $this->slugLocked = true;
    }    


    public function render()
    {
        return view('livewire.admin.courses.create', [

            'categories' => Category::orderBy('name')->get(),

            'levels' => CourseLevel::cases(),

            'statuses' => CourseStatus::cases(),

        ])->layout('layouts.app');
    }

    public function updatedFormTitle(string $value): void
    {
        if (! $this->slugLocked) {
            $this->form->slug = Str::slug($value);
        }
    }

}
