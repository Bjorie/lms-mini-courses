<?php

namespace App\Livewire\Admin\Courses;

use Livewire\Component;
use App\Livewire\Forms\CourseForm;
use App\Models\Category;
use App\Models\Course;
use App\Enums\CourseLevel;
use App\Enums\CourseStatus;


class Edit extends Component
{

    public CourseForm $form;

    public function mount(Course $course): void
    {
        $this->form->setCourse($course);
    }

    public function save()
    {
        $this->form->update();

        session()->flash(
            'success',
            'Курс успешно обновлен.'
        );

        return redirect()->route('admin.courses.index');
    }

    public function render()
    {
        return view('livewire.admin.courses.edit', [

            'categories' => Category::orderBy('name')->get(),

            'levels' => CourseLevel::cases(),

            'statuses' => CourseStatus::cases(),

        ])->layout('layouts.app');
    }
}
