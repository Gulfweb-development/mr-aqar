<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifiedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $code;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.forget')
            ->from('info@mr-aqar.com','Mr Aqar')
            ->subject('Forgot password code')
            ->with([
                'user'=>$this->user,
                'code'=>$this->code
            ]);
    }
}
