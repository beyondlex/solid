<?php

namespace App\Listeners;

use App\Events\DeviceReqEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeviceReqSubscriber implements ShouldQueue
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
    public function handle($event)
    {
        //
    }

	/**
	 * @param DeviceReqEvent $event
	 */
    public function onDeviceReq($event) {
//    	Log::debug('event', (array)$event->log);
		$event->saveLog();
	}

    public function subscribe($events) {
		$events->listen(DeviceReqEvent::class, self::class.'@onDeviceReq');
	}
}
