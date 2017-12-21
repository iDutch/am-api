<?php

namespace App\Listeners;

use App\Events\ScheduleChanged;
use iDutch\CrossbarHttpBridge\HttpBridge\HttpBridge;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use GuzzleHttp\Client;

class SendWebhookRequest
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
        $publisher = $HttpBridge->createPublisher('https', 'cb.hoogstraaten.eu', 443, '/publish', 'mykey', 'mysecret', null, false);

        $publisher->publish('eu.hoogstraaten.fishtank.publish', [['schedule_id' => $event->schedule->id]]);
    }
}
