<?php

namespace App\Jobs;

use App\Mail\RegisterMember;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to;
    protected $message;
    protected $data;
    protected $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to,$message,$data=[],$type="new_user")
    {
        $this->to=$to;
        $this->message=$message;
        $this->data=$data;
        $this->type=$type;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        switch ($this->type){
            case "new_user":
                Mail::to($this->to)->send(new RegisterMember($this->message));
                break;
        }
    }


}
