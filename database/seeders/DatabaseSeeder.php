<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Заполнение базы демонстрационными данными.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,

            CategorySeeder::class,

            CourseSeeder::class,
            SectionSeeder::class,
            LessonSeeder::class,
        ]);
    }
}