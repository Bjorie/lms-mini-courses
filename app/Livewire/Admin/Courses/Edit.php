<?php

namespace App\Livewire\Admin\Courses;

use App\DTO\Course\CourseData;
use App\Enums\CourseLevel;
use App\Enums\CourseStatus;
use App\Livewire\Forms\CourseForm;
use App\Models\Course;
use App\Services\Course\CourseService;
use Livewire\Component;
use App\Services\Category\CategoryCacheService;

class Edit extends Component
{
    public CourseForm $form;

    public function mount(Course $course): void
    {
        $this->form->setCourse($course);
    }

    public function save(
        CourseService $service,
    ) {
        $this->form->generateSlug();
        $this->form->validate();

        $course = $this->form->course;

        abort_unless($course, 404);

        $service->update(
            $course,
            CourseData::fromForm($this->form),
        );

        session()->flash(
            'success',
            'Курс успешно обновлен.'
        );

        return redirect()->route(
            'admin.courses.index',
        );
    }

    public function render(CategoryCacheService $categoryCache)
    {
        return view('livewire.admin.courses.edit', [
            'categories' => $categoryCache->all(),
            'levels' => CourseLevel::cases(),
            'statuses' => CourseStatus::cases(),
        ])
            ->layout('layouts.app')
            ->title('Редактировать курс');
    }
    
}