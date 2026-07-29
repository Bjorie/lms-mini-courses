<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public function delete(Category $category): void
    {
        if ($category->courses()->exists()) {
            session()->flash(
                'error',
                'Нельзя удалить категорию, пока к ней привязаны курсы.'
            );

            return;
        }

        $category->delete();

        session()->flash(
            'success',
            'Категория успешно удалена.'
        );
    }

    public function render(): View
    {
        return view('livewire.admin.categories.index', [
            'categories' => Category::query()
                ->withCount('courses')
                ->orderBy('name')
                ->get(),
        ])->layout('layouts.app');
    }
}