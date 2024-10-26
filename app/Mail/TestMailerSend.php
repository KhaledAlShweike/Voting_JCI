<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use MailerSend\MailerSend;
use MailerSend\Helpers\Builder\Recipient;
use MailerSend\Helpers\Builder\EmailParams;

class TestMailerSend extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        $mailersend = new MailerSend(['api_key' => env('MAILERSEND_API_KEY')]);

        $recipients = [
            new Recipient('salahjoja1@gmail.com', 'Salah Joja'),
        ];

        $emailParams = (new EmailParams())
            ->setFrom(env('MAIL_FROM_ADDRESS'))
            ->setFromName(env('MAIL_FROM_NAME'))
            ->setRecipients($recipients)
            ->setSubject($this->details['title'])
            ->setHtml("<h1>{$this->details['title']}</h1><p>{$this->details['body']}</p>")
            ->setText($this->details['body']);

        return $mailersend->email->send($emailParams);
    }

    /**
     * Create a new message instance.
     */


    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Test Mailer Send',
    //     );
    // }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    // public function attachments(): array
    // {
    //     return [];
    // }
}
