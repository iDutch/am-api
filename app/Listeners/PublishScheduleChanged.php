<?php

namespace App\Listeners;

use App\Events\ScheduleChanged;
use iDutch\CrossbarHttpBridge\HttpBridge\HttpBridge;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PublishScheduleChanged
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
     * @param  ScheduleChanged  $event
     * @return void
     */
    public function handle(ScheduleChanged $event)
    {
        $HttpBridge = new HttpBridge();
        $publisher = $HttpBridge->createPublisher('https', 'cb.hoogstraaten.eu', 443, '/publish', config('app.crossbar_http_bridge_publisher_key'), config('app.crossbar_http_bridge_publisher_secret'), null, false);

        $publisher->publish('eu.hoogstraaten.fishtank.publish', [['schedule_id' => $event->schedule->id]]);
    }
}
