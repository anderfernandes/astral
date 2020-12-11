<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Sale;
use PDF;

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
        $organization = \App\Setting::find(1);

        $this->sale = $sale;

        $this->invoice = PDF::loadView('pdf.invoice', ['sale' => $sale])
            ->stream("Invoice #$sale->id.pdf");
        
        $this->tickets = PDF::loadView('admin.tickets.tickets', [
            'sale' => $sale, 
            'organization' => $organization
        ])->stream("Tickets #$sale->id.pdf");
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
                    ->subject("Your {$settings->organization} tickets, {$customer}! (Sale #{$sale->id})")
                    ->markdown("email.online-payment")
                    ->attachData($this->invoice, "Invoice #$sale->id.pdf", ["mime" => "application/pdf"])
                    ->attachData($this->tickets, "Tickets #$sale->id.pdf", ["mime" => "application/pdf"]);
    }
}
