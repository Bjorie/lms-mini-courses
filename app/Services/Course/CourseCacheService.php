<?php

namespace App\Services\Course;

use App\Models\Course;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class CourseCacheService
{
    public const ADMIN_LIST_IDS_KEY = 'admin.courses.list.ids';

    public function adminList(): Collection
    {
        $ids = Cache::remember(
            self::ADMIN_LIST_IDS_KEY,
            now()->addMinutes(10),
            fn (): array => Course::query()
                ->latest()
                ->pluck('id')
                ->all()
        );

        if ($ids === []) {
            return collect();
        }

        $courses = Course::query()
            ->with(['category', 'author'])
            ->whereIn('id', $ids)
            ->get()
            ->keyBy('id');

        return collect($ids)
            ->map(fn (int $id) => $courses->get($id))
            ->filter()
            ->values();
    }

    public function clearAdminList(): void
    {
        Cache::forget(self::ADMIN_LIST_IDS_KEY);
    }
}