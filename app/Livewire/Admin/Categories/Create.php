<?php

namespace App\Livewire\Admin\Categories;

use Livewire\Component;

use App\Models\Category;
use Illuminate\Support\Str;

class Create extends Component
{
    public string $name = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
        ]);

        session()->flash('success', 'Категория успешно создана.');

        return redirect()->route('admin.categories.index');
    }

    public function render()
    {
        return view('livewire.admin.categories.create')
            ->layout('layouts.app');
    }
}
