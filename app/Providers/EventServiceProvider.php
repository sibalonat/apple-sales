<?php

namespace App\Providers;

use App\Events\OrderCompletedEvent;
use App\Events\ProductUpdatedEvent;
use Illuminate\Support\Facades\Event;
use App\Listeners\NotifyAdminListener;
use Illuminate\Auth\Events\Registered;
use App\Listeners\NotifyVendorListener;
use App\Listeners\OrderCompletedListener;
use App\Listeners\ProductUpdatedListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ProductUpdatedEvent::class => [
            ProductUpdatedListener::class
        ],
        OrderCompletedEvent::class => [
            NotifyAdminListener::class,
            NotifyVendorListener::class,
        ]
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
