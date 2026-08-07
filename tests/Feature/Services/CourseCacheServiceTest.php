<?php

namespace Tests\Feature\Services;

use App\Events\CourseChanged;
use App\Listeners\ClearAdminCourseListCache;
use App\Models\Course;
use App\Services\Course\CourseCacheService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CourseCacheServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_list_caches_course_ids(): void
    {
        Cache::forget(CourseCacheService::ADMIN_LIST_IDS_KEY);

        $course1 = Course::factory()->create();
        $course2 = Course::factory()->create();

        $service = app(CourseCacheService::class);

        $courses = $service->adminList();

        $this->assertCount(2, $courses);

        $this->assertTrue(
            Cache::has(CourseCacheService::ADMIN_LIST_IDS_KEY)
        );

        $cachedIds = Cache::get(
            CourseCacheService::ADMIN_LIST_IDS_KEY
        );

        $this->assertEqualsCanonicalizing(
            [$course1->id, $course2->id],
            $cachedIds
        );
    }

    public function test_admin_list_uses_cached_ids(): void
    {
        $course1 = Course::factory()->create();
        $course2 = Course::factory()->create();

        Cache::put(
            CourseCacheService::ADMIN_LIST_IDS_KEY,
            [$course1->id],
            now()->addMinutes(10)
        );

        $service = app(CourseCacheService::class);

        $courses = $service->adminList();

        $this->assertCount(1, $courses);

        $this->assertSame(
            $course1->id,
            $courses->first()->id
        );

        $this->assertNotSame(
            $course2->id,
            $courses->first()->id
        );
    }

    public function test_course_changed_listener_clears_admin_list_cache(): void
    {
        $course = Course::factory()->create();

        Cache::put(
            CourseCacheService::ADMIN_LIST_IDS_KEY,
            [$course->id],
            now()->addMinutes(10)
        );

        $this->assertTrue(
            Cache::has(CourseCacheService::ADMIN_LIST_IDS_KEY)
        );

        $listener = app(ClearAdminCourseListCache::class);

        $listener->handle(
            new CourseChanged($course)
        );

        $this->assertFalse(
            Cache::has(CourseCacheService::ADMIN_LIST_IDS_KEY)
        );
    }
}