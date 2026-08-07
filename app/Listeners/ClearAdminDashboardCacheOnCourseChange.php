<?php

namespace App\Listeners;

use App\Events\CourseChanged;
use App\Services\Dashboard\DashboardCacheService;

class ClearAdminDashboardCacheOnCourseChange
{
    public function __construct(
        private readonly DashboardCacheService $cacheService,
    ) {
    }

    public function handle(CourseChanged $event): void
    {
        $this->cacheService->clear();
    }
}