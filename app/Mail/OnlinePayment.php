<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Sale;

class OnlinePayment extends Mailable
{
    use Queueable, SerializesModels;

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
        $settings = \App\Setting::find(1);

        $customer = $this->sale->customer->firstname;

        $sale = $this->sale;

        return $this->from($settings->email, $settings->organization)
                    ->subject("Your {$settings->organization}, {$customer}! (Sale #{$sale->id})")
                    ->markdown("email.online-payment");
    }
}
