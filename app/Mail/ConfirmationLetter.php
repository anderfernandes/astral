<?php

namespace App\Mail;

use App\Sale;

use Session;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmationLetter extends Mailable
{
    use Queueable, SerializesModels;

    // Make the sale object available to all methods of this class
    public $sale;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $sale = $this->sale;
        // Do not repeat organization and customer name if they are the same
        $name = ($sale->organization->name == $sale->customer->firstname) ? $sale->organization->name : $sale->organization->name .' ('. $sale->customer->fullname .')';
        // If the sale is for an organization, print only its name
        $customer = $sale->sell_to_organization ? $name : $sale->customer->fullname;
        // Get organization name
        $organization = \App\Setting::find(1)->organization;
        $subject =  $organization . ' Confirmation Letter - ' . $customer;

        $this->subject($subject)
             ->view('email.confirmation');

    }
}
