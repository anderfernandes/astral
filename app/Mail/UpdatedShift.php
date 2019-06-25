<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdatedShift extends Mailable
{
    use Queueable, SerializesModels;

    public $shift;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Shift $shift, User $user)
    {
        $this->shift = $shift;
        $this->user  = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $shift = $this->shift;
        $user  = $this->user;

        $organization = \App\Setting::find(1)->organization;

        $subject = "$user->firstname, a shift that you are a part of has been updated - $organization";

        return $this->subject($subject)
                    ->view('email.updated-shift');
    }
}
