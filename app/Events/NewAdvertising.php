<?php


namespace App\Events;


use App\Models\Advertising;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewAdvertising
{
    use SerializesModels,Dispatchable;
    public $advertising;
    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Advertising  $advertising
     * @return void
     */
    public function __construct(Advertising $advertising)
    {
        $this->advertising = $advertising;
    }

}