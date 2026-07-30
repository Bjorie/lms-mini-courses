<?php

namespace Tests\Feature\Services;

use App\Exceptions\AlreadyEnrolledException;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Services\Enrollment\EnrollmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Database\Seeders\RoleSeeder;
use Spatie\Permission\PermissionRegistrar;
use App\Jobs\SendEnrollmentEmailJob;
use Illuminate\Support\Facades\Queue;
use App\Mail\EnrollmentMail;
use Illuminate\Support\Facades\Mail;

class EnrollmentServiceTest extends TestCase
{
    use RefreshDatabase;

    private EnrollmentService $service;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $this->seed(RoleSeeder::class);

        $this->service = app(EnrollmentService::class);
    }

    public function test_user_can_enroll_in_course(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $enrollment = $this->service->enroll(
            $user,
            $course,
            49.99
        );

        $this->assertInstanceOf(
            Enrollment::class,
            $enrollment
        );

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $user->id,
            'course_id' => $course->id,
            'paid_amount' => 49.99,
        ]);

        $this->assertNotNull($enrollment->enrolled_at);
    }

    public function test_user_cannot_enroll_in_same_course_twice(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $this->service->enroll($user, $course);

        $this->expectException(
            AlreadyEnrolledException::class
        );

        $this->service->enroll($user, $course);
    }

    public function test_service_detects_existing_enrollment(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $this->assertFalse(
            $this->service->isEnrolled($user, $course)
        );

        $this->service->enroll($user, $course);

        $this->assertTrue(
            $this->service->isEnrolled($user, $course)
        );
    }

    public function test_user_can_unenroll_from_course(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $this->service->enroll($user, $course);

        $this->service->unenroll($user, $course);

        $this->assertFalse(
            $this->service->isEnrolled($user, $course)
        );

        $this->assertDatabaseMissing('enrollments', [
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
    }

    public function test_unenrolling_without_enrollment_does_not_fail(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $this->service->unenroll($user, $course);

        $this->assertFalse(
            $this->service->isEnrolled($user, $course)
        );
    }

    public function test_default_paid_amount_is_zero(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $enrollment = $this->service->enroll(
            $user,
            $course
        );

        $this->assertSame(
            '0.00',
            $enrollment->paid_amount
        );
    }

    public function test_enrollment_dispatches_email_job(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $course = Course::factory()->create();

        $this->service->enroll($user, $course);

        Queue::assertPushed(
            SendEnrollmentEmailJob::class,
            function (SendEnrollmentEmailJob $job) use ($user, $course) {
                return $job->user->is($user)
                    && $job->course->is($course);
            }
        );
    }

    public function test_job_sends_enrollment_email(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $course = Course::factory()->create();

        $job = new SendEnrollmentEmailJob($user, $course);

        $job->handle();

        Mail::assertSent(EnrollmentMail::class, function (EnrollmentMail $mail) use ($course) {
            return $mail->course->is($course);
        });
    }    


}