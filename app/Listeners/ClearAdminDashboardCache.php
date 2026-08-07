<?php

namespace App\Listeners;

use App\Events\EnrollmentCreated;
use App\Services\Dashboard\DashboardCacheService;

class ClearAdminDashboardCache
{
    public function __construct(
        private readonly DashboardCacheService $cacheService,
    ) {
    }

    public function handle(EnrollmentCreated $event): void
    {
        $this->cacheService->clear();
    }
}