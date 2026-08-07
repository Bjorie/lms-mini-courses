<?php

namespace App\Services\Category;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryCacheService
{
    public const KEY = 'categories.all';

    public function all(): Collection
    {
        $categories = Cache::remember(
            self::KEY,
            now()->addHour(),
            fn (): array => Category::query()
                ->orderBy('name')
                ->get(['id', 'name', 'slug'])
                ->toArray()
        );

        return collect($categories)
            ->map(fn (array $category) => (object) $category);
    }

    public function clear(): void
    {
        Cache::forget(self::KEY);
    }
}