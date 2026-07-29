<?php

namespace App\Livewire\Admin\Courses;

use App\DTO\Course\CourseData;
use App\Enums\CourseLevel;
use App\Enums\CourseStatus;
use App\Livewire\Forms\CourseForm;
use App\Models\Category;
use App\Services\Course\CourseService;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public CourseForm $form;

    public bool $slugLocked = false;

    public function save(
        CourseService $service,
    ) {
        $this->form->generateSlug();
        $this->form->validate();

        $user = auth()->user();

        abort_unless($user, 403);

        $course = $service->create(
            CourseData::fromForm($this->form),
            $user,
        );

        session()->flash(
            'success',
            'Курс успешно создан.'
        );

        return redirect()->route(
            'admin.courses.edit',
            $course,
        );
    }

    public function updatedFormSlug(): void
    {
        $this->slugLocked = true;
    }

    public function updatedFormTitle(
        string $value,
    ): void {
        if (! $this->slugLocked) {
            $this->form->slug = Str::slug($value);
        }
    }

    public function render()
    {
        return view(
            'livewire.admin.courses.create',
            [
                'categories' => Category::query()
                    ->orderBy('name')
                    ->get(),

                'levels' => CourseLevel::cases(),

                'statuses' => CourseStatus::cases(),
            ],
        )->layout('layouts.app');
    }
}