<?php

namespace App\Listeners;

use App\Events\EmailProcessed;
use App\Mail\GalleryCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmail
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EmailProcessed $event)
    {
        Mail::to(auth()->user()->email)->send(new GalleryCreated($event->gallery));
    }
}
