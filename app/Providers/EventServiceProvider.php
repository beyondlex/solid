<?php

namespace App\Providers;

use Api\Hik\Listeners\HikEventListener;
use App\Listeners\DeviceReqSubscriber;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];

    protected $subscribe = [
		DeviceReqSubscriber::class,
        //HikEventListener::class,
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
