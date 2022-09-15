<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Payment
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    /**
     * @var \App\Models\Payment
     */
    public $payment;

    /**
     * Create a new event instance.
     *
     * @param $message
     * @param \App\Models\Payment $payment
     */
    public function __construct($message, \App\Models\Payment $payment)
    {
        $this->message=$message;
        $this->payment = $payment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
