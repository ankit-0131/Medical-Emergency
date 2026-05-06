<?php

namespace App\Mail;

use App\Models\Emergency;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmergencyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param Emergency $emergency  The emergency record
     * @param string    $recipient  'admin' or 'contact'
     */
    public function __construct(
        public Emergency $emergency,
        public string $recipient = 'admin'
    ) {}

    /**
     * Get the message envelope (subject).
     */
    public function envelope(): Envelope
    {
        $subject = $this->recipient === 'admin'
            ? '🚨 New Emergency Alert - Immediate Attention Required'
            : '🚨 Medical Emergency Alert - ' . $this->emergency->user->name;

        return new Envelope(subject: $subject);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.emergency',
        );
    }
}
