<?php

namespace App\Listeners\Payment;

use App\Events\Payment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Payment  $event
     * @return void
     */
    public function handle(Payment $event)
    {
        $res= Mail::to(optional($event->payment->user)->email)->send(new \App\Mail\PaymentMail($event->message,$event->payment));

    }
}
