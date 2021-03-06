<?php

namespace App\Providers;

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

        'App\Events\CreatingUser' => [],

        'App\Events\CreatedUser' => [
            'App\Listeners\SendMailUserCreated',
            'App\Listeners\CreateVacationData',
        ],

        'App\Events\UpdatingUser' => [],

        'App\Events\UpdatedUser' => [],

        'App\Events\CreatedVacationRequest' => [
            'App\Listeners\SendMailVacationRequestCreated',
        ],

        'App\Events\UpdatedVacationRequest' => [],

        'App\Events\ApproveVacationRequest' => [
            'App\Listeners\SendMailVacationRequestApprove',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
