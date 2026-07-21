<?php

namespace App\Livewire\Admin\Categories;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;

class Edit extends Component
{
    public Category $category;

    public string $name = '';

    public function mount(Category $category)
    {
        $this->category = $category;
        $this->name = $category->name;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3|max:255|unique:categories,name,' . $this->category->id,
        ]);

        $this->category->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
        ]);

        session()->flash(
            'success',
            'Категория обновлена.'
        );

        return redirect()->route(
            'admin.categories.index'
        );
    }

    public function render()
    {
        return view(
            'livewire.admin.categories.edit'
        )->layout('layouts.app');
    }
}
