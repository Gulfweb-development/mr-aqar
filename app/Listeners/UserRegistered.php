<?php


namespace App\Listeners;
use App\Events\UserRegistered as  UserRegisteredEvent;
use App\Http\Controllers\Controller;
use App\Mail\RegisterMember;
use App\Models\Setting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class UserRegistered implements ShouldQueue
{
    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'notifyUser';
    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 0;

    /**
     * Reward a gift card to the customer.
     *
     * @param UserRegistered $event
     * @return void
     */
    public function handle(UserRegisteredEvent $event)
    {
        $user=$event->user;
         $settings=Setting::whereIn('setting_key',['welcome_email_text_ar','welcome_email_text_en'])->get()->keyBy('setting_key');
         $message=optional($event->user)->lang=="ar"?optional($settings['welcome_email_text_ar'])->setting_value:optional($settings['welcome_email_text_en'])->setting_value;
         $res= Mail::to(optional($event->user)->email)->send(new RegisterMember($message));
        // $code=rand(10000,99999);
        // $message="Activation Code : ".$code;
        // $user->sms_code=$code;
        //  Controller::sendSms($message,$user->mobile);
        // dispatch(new EmailNotify(optional($event->user)->email,$message))->onQueue('notifyUser')->afterResponse();
    }

    /**
     * Determine whether the listener should be queued.
     *
     * @param UserRegisteredEvent $event
     * @return bool
     */
    public function shouldQueue(UserRegisteredEvent $event)
    {
        return true;
    }

}