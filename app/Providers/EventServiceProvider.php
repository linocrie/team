<?php

namespace App\Providers;

use App\Events\ProfessionCreatedOrUpdated;
use App\Events\UserRegisteredEvent;
use App\Listeners\SendEmailProfessionUpdated;
use App\Listeners\SendWelcomeEmailListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserRegisteredEvent::class => [
            SendWelcomeEmailListener::class
        ],
        ProfessionCreatedOrUpdated::class => [
            SendEmailProfessionUpdated::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
