<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use MailerSend\Helpers\Builder\Variable;
use MailerSend\Helpers\Builder\Personalization;
use MailerSend\LaravelDriver\MailerSendTrait;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels, MailerSendTrait;

    public function build()
    {
        $to = Arr::get($this->to, '0.address');

        return $this->view('emails.test_html')
            ->text('emails.test_text')
            ->attachFromStorageDisk('public', 'example.png')
            ->mailersend(
                // Template ID
                null,
                // Variables for simple personalization
                [
                    new Variable($to, ['name' => 'Your Name'])
                ],
                // Tags
                ['tag'],
                // Advanced personalization
                [
                    new Personalization($to, [
                        'var' => 'variable',
                        'number' => 123,
                        'object' => [
                            'key' => 'object-value'
                        ],
                        'objectCollection' => [
                            [
                                'name' => 'John'
                            ],
                            [
                                'name' => 'Patrick'
                            ]
                        ],
                    ])
                ]
        );
    }
}
