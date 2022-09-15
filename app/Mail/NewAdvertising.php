<?php

namespace App\Mail;

use App\Models\Advertising;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewAdvertising extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Advertising
     */
    public $advertising;
    public $message;

    /**
     * Create a new message instance.
     *
     * @param Advertising $advertising
     */
    public function __construct(Advertising $advertising)
    {
        //
        $this->advertising = $advertising;
        $this->message='Your Advertising Create Successfully';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.newAdvertising')->subject('New Advertising');
    }
}
