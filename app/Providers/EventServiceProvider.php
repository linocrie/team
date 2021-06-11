<?php

namespace App\Providers;


use App\Events\EmailProcessed;
use App\Listeners\SendEmail;
use App\Events\ProfessionCreatedOrUpdated;
use App\Listeners\SendEmailProfessionUpdated;
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

        EmailProcessed::class => [
            SendEmail::class,
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

    }
}
