<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\{ Schedule, User };

class NewSchedule extends Mailable
{
    use Queueable, SerializesModels;

    public $schedule;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Schedule $schedule, User $user)
    {
        $this->schedule = $schedule;
        $this->user     = $user;
    }

    /**
     * Build the message. Sends email to each individual in the schedule
     *
     * @return $this
     */
    public function build()
    {
        $schedule = $this->schedule;
        $user     = $this->user;

        $organization = \App\Setting::find(1)->organization;

        $subject = "$user->firstname, a new work schedule has been created - $organization";
        

        return $this->subject($subject)
                    ->view('email.new-schedule');
    }
}
