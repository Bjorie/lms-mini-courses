<?php

namespace App\Jobs;

use App\Mail\EnrollmentMail;
use App\Models\Course;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendEnrollmentEmailJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public User $user,
        public Course $course,
    ) {
    }

    public function handle(): void
    {
        Mail::to($this->user)
            ->send(new EnrollmentMail($this->course));
    }
}