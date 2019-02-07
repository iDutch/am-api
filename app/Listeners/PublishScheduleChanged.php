<?php

namespace App\Listeners;

use App\Events\ScheduleChanged;
use iDutch\CrossbarHttpBridge\CrossbarHttpBridgeInterface;

class PublishScheduleChanged
{
    /**
     * @var CrossbarHttpBridgeInterface $crossbarHttpBridge
     */
    private $crossbarHttpBridge;

    /**
     * PublishScheduleChanged constructor.
     * @param CrossbarHttpBridgeInterface $crossbarHttpBridge
     */
    public function __construct(CrossbarHttpBridgeInterface $crossbarHttpBridge)
    {
        $this->crossbarHttpBridge = $crossbarHttpBridge;
    }

    /**
     * @param ScheduleChanged $event
     * @return Void
     */
    public function handle(ScheduleChanged $event): void
    {
        $this->crossbarHttpBridge->publish('eu.hoogstraaten.fishtank.publish', [['schedule_id' => $event->schedule->id]]);
    }
}
