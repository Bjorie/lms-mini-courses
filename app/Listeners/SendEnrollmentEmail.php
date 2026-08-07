<?php

namespace App\Listeners;

use App\Events\EnrollmentCreated;
use App\Jobs\SendEnrollmentEmailJob;

class SendEnrollmentEmail
{
    public function handle(EnrollmentCreated $event): void
    {
        SendEnrollmentEmailJob::dispatch(
            $event->user,
            $event->course,
        )->afterCommit();
    }
}