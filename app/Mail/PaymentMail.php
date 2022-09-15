<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    /**
     * @var Payment
     */
    public $payment;

    /**
     * Create a new message instance.
     *
     * @param $message
     * @param Payment $payment
     */
    public function __construct($message,Payment $payment)
    {
        $this->message=$message;
        $this->payment = $payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.payment')->subject('payment detail');

    }
}
