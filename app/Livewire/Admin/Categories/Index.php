<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;

class Index extends Component
{

    public function delete(Category $category): void
    {
        $category->delete();

        session()->flash(
            'success',
            'Категория успешно удалена.'
        );
    }
    public function render()
    {
    return view('livewire.admin.categories.index', [
        'categories' => Category::orderBy('name')->get(),
    ])->layout('layouts.app');
    }
}
