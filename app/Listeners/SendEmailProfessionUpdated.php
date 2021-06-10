<?php

namespace App\Listeners;

use App\Events\ProfessionCreatedOrUpdated;
use App\Mail\ProfessionCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailProfessionUpdated
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
     * @param  ProfessionCreatedOrUpdated  $event
     * @return void
     */
    public function handle(ProfessionCreatedOrUpdated $event)
    {
        Mail::to(auth()->user()->email)
            ->send(new ProfessionCreated($event->user, $event->beforeProfessions, $event->updatedProfessions));
    }
}
