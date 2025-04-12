<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecoverPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $recover;

    public function __construct($user, $recover)
    {
        $this->user = $user;
        $this->recover = $recover;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recover Password Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'recoverPassword.recover',
            with: [
                'user' => $this->user,
                'token' => $this->recover,
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
