<?php

namespace App\Listeners;

use App\Events\CourseChanged;
use App\Services\Course\CourseCacheService;

class ClearAdminCourseListCache
{
    public function __construct(
        private readonly CourseCacheService $cacheService,
    ) {
    }

    public function handle(CourseChanged $event): void
    {
        $this->cacheService->clearAdminList();
    }
}