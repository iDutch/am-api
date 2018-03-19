<?php

namespace App\Listeners;

use App\Events\ScheduleChanged;
use iDutch\CrossbarHttpBridge\HttpBridge\CrossbarHttpBridgeInterface;
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
     * @param ScheduleChanged $event
     * @param CrossbarHttpBridgeInterface $crossbarHttpBridge
     * @return void
     */
    public function handle(ScheduleChanged $event, CrossbarHttpBridgeInterface $crossbarHttpBridge)
    {
        $crossbarHttpBridge->publish('eu.hoogstraaten.fishtank.publish', [['schedule_id' => $event->schedule->id]]);
    }
}
