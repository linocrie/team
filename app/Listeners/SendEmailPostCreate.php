<?php

namespace App\Listeners;

use App\Events\PostCreate;
use App\Mail\PostCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailPostCreate
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
     * @param  object  $event
     * @return void
     */
    public function handle(PostCreate $event)
    {
        Mail::to(auth()->user())->send(new PostCreated($event->post));
    }
}
