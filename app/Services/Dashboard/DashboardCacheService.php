<?php

namespace App\Services\Dashboard;

use Illuminate\Support\Facades\Cache;

class DashboardCacheService
{
    public const STATS_KEY = 'admin.dashboard.stats';

    public function clear(): void
    {
        Cache::forget(self::STATS_KEY);
    }
}