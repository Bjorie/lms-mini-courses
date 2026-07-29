<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Laravel',
            'PHP',
            'Livewire',
            'JavaScript',
            'TypeScript',
            'Vue.js',
            'Tailwind CSS',
            'HTML и CSS',
            'MySQL',
            'Docker',
            'Git',
            'Linux',
            'DevOps',
            'Архитектура ПО',
            'Тестирование',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => str($category)->slug()],
                [
                    'name' => $category,
                ]
            );
        }
    }
}