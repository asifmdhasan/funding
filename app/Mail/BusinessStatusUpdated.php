<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class BusinessStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;
    public $mailData;
    /**
     * Create a new message instance.
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        //add log here
        Log::info('Receved envelope: ', $this->mailData);
        return new Envelope(
            subject: 'Business status ' . $this->mailData['status'] . '  for ' . $this->mailData['business_name'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        //add log here
        Log::info('send to blade...');
        return new Content(
            view: 'admin.emails.business-status-updated',
            with: [
                'mailData' => $this->mailData,
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
        return [];
    }
}
