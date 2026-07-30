<?php

namespace App\Mail;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnrollmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Course $course
    ) {}

    public function build(): static
    {
        return $this
            ->subject('Вы успешно записались на курс')
            ->view('emails.enrollment');
    }
}