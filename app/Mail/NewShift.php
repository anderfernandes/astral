<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\{ Shift, User };

class NewShift extends Mailable
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
        $user = $this->user;

        $organization = \App\Setting::find(1)->organization;

        $subject = "$user->firstname, you have been added to new a shift - $organization";

        return $this->subject($subject)
                    ->view('email.new-shift');
    }
}
