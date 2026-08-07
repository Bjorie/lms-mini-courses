<?php

namespace Tests\Feature\Listeners;

use App\Events\EnrollmentCreated;
use App\Listeners\ClearAdminDashboardCache;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ClearAdminDashboardCacheTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_clears_admin_dashboard_cache(): void
    {
        Cache::put('admin.dashboard.stats', [
            'courses_count' => 10,
        ], now()->addMinutes(5));

        $this->assertTrue(
            Cache::has('admin.dashboard.stats')
        );

        $user = User::factory()->create();
        $course = Course::factory()->create();

        $listener = app(ClearAdminDashboardCache::class);

        $listener->handle(
            new EnrollmentCreated($user, $course)
        );

        $this->assertFalse(
            Cache::has('admin.dashboard.stats')
        );
    }
}