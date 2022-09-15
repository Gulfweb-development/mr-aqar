<?php

namespace App\Listeners;

use App\Events\NewAdvertising;
use App\Models\Advertising;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmail
{
    /**
     * @var Advertising
     */


    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  NewAdvertising  $event
     * @return void
     */
    public function handle(NewAdvertising $event)
    {
        $res= Mail::to(optional($event->advertising->user)->email)->send(new \App\Mail\NewAdvertising($event->advertising));

    }
}
