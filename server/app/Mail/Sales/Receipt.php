<?php

namespace App\Mail\Sales;

use App\Models\Sale;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Receipt extends Mailable
{
    private string $organization;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Sale $sale
    ) {
        $this->organization = (new Setting())->first()->organization;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Receipt #{$this->sale->id} | $this->organization",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.sales.receipt',
            with: [
                'organization' => $this->organization
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {

        return [
            Attachment::fromStorage("receipt_{$this->sale->id}.pdf")
                ->as("Receipt #{$this->sale->id}.pdf")
                ->withMime("application/pdf")
        ];
    }
}
