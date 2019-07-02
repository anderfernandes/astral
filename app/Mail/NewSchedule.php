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
    }

    /**
     * Build the message. Sends email to each individual in the schedule
     *
     * @return $this
     */
    public function build()
    {
        $schedule = $this->schedule;

        $organization = \App\Setting::find(1)->organization;

        /*foreach ($schedule->shifts as $shift)
          foreach($shift->employees as $employee)
            array_push($employees, $employee);*/
        
        //$employees = $employees->unique();

        // Send two emails to schedule creator if they are on the schedule?

        $subject = "$user->firstname, a new work schedule has been posted and you are on it - $organization";
        

        return $this->subject($subject)
                    ->view('email.new-schedule');
    }
}
