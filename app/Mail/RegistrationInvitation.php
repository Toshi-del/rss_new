<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $name;
    public $record_id;

    /**
     * Create a new message instance.
     */
    public function __construct($email, $name, $record_id)
    {
        $this->email = $email;
        $this->name = $name;
        $this->record_id = $record_id;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Complete Your Registration - RSS Citi Health Services',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-invitation',
            with: [
                'email' => $this->email,
                'name' => $this->name,
                'record_id' => $this->record_id,
            ],
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
