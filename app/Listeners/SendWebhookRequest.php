<?php

namespace App\Listeners;

use App\Events\ScheduleChanged;
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
        $client = new Client(['headers' => ['Content-Type' => 'application/json']]);
        $response = $client->post('https://cb.hoogstraaten.eu/webhook', ['body' => json_encode([
            'schedule_id' => $event->schedule->id,
        ])]);
    }
}
