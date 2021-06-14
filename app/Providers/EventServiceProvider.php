<?php

namespace App\Providers;


use App\Events\EmailProcessed;
use App\Events\PostCreate;
use App\Listeners\SendEmail;
use App\Events\ProfessionCreatedOrUpdated;
use App\Events\UserRegisteredEvent;
use App\Listeners\SendEmailPostCreate;
use App\Listeners\SendEmailProfessionUpdated;
use App\Listeners\SendWelcomeEmailListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use function Illuminate\Events\queueable;

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
        EmailProcessed::class => [
            SendEmail::class,
        ],
        ProfessionCreatedOrUpdated::class => [
            SendEmailProfessionUpdated::class
        ],
        PostCreate::class => [
            SendEmailPostCreate::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

    }
}
