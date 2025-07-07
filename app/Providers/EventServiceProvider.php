<?php

namespace App\Providers;

use App\Events\ContactCreated;
use App\Events\ContactUpdated;
use App\Events\ContactDeleted;
use App\Listeners\SendContactNotifications;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     */
    protected $listen = [
        ContactCreated::class => [
            SendContactNotifications::class . '@handleContactCreated',
        ],
        ContactUpdated::class => [
            SendContactNotifications::class . '@handleContactUpdated',
        ],
        ContactDeleted::class => [
            SendContactNotifications::class . '@handleContactDeleted',
        ],
    ];

    /**
     * The subscriber classes to register.
     */
    protected $subscribe = [
        // Vazio - usando $listen acima
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}