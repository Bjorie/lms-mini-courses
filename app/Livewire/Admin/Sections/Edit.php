<?php

namespace App\Livewire\Admin\Sections;

use App\Models\Section;
use Livewire\Component;

class Edit extends Component
{
    public Section $section;

    public string $title = '';

    public function mount(Section $section): void
    {
        $this->section = $section;
        $this->title = $section->title;
    }

    public function save(): void
    {
        $this->validate([
            'title' => ['required', 'min:3', 'max:255'],
        ]);

        $this->section->update([
            'title' => $this->title,
        ]);

        session()->flash(
            'success',
            'Раздел успешно обновлён.'
        );

        $this->redirectRoute(
            'admin.courses.sections.index',
            $this->section->course
        );
    }

    public function render()
    {
        return view('livewire.admin.sections.edit')
            ->layout('layouts.app');
    }
}
