<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InterviewInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    private $emailCandidate;

    private $nameCandidate;

    private $emailPerusahaan;

    private $namePerusahaan;

    /**
     * Create a new message instance.
     */
    public function __construct($emailCandidate, $nameCandidate, $emailPerusahaan, $namePerusahaan)
    {
        $this->emailCandidate = $emailCandidate;
        $this->nameCandidate = $nameCandidate;

        $this->namePerusahaan = $namePerusahaan;
        $this->emailPerusahaan = $emailPerusahaan;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: $this->namePerusahaan.' Interview Invitation Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.interview-invitation-mail',
            with: [
                'nameCandidate' => $this->nameCandidate,
                'emailCandidate' => $this->emailCandidate,
                'namePerusahaan' => $this->namePerusahaan,
                'emailPerusahaan' => $this->emailPerusahaan,
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
