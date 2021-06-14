<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use App\Mail\Welcome;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailListener
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
     * @param  UserRegisteredEvent  $event
     * @return void
     */
    public function handle(UserRegisteredEvent $event)
    {
//        dd($event->user);
        $email_data = array(
            'name' => $event->user->name,
            'email' => $event->user->email,
        );
        Mail::to($email_data['email'])->send(new Welcome());
    }
}
