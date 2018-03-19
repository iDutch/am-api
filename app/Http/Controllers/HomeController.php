<?php

namespace App\Http\Controllers;

use App\Schedule;
use iDutch\CrossbarHttpBridge\HttpBridge\CrossbarHttpBridgeInterface;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     * @param CrossbarHttpBridgeInterface $crossbarHttpBridge
     * @return \Illuminate\Http\Response
     */
    public function index(CrossbarHttpBridgeInterface $crossbarHttpBridge)
    {
        $schedules =  Schedule::where('user_id', Auth::id())->get();

        $subscription = $crossbarHttpBridge->call('wamp.subscription.lookup', ['eu.hoogstraaten.fishtank.publish']);
        $clients = [];

        if (!is_null($subscription['args'][0])) {
            $subscribers = $crossbarHttpBridge->call('wamp.subscription.list_subscribers', [$subscription['args'][0]]);
            foreach ($subscribers['args'][0] as $key => $subscriber) {
                $clients[$key] = $crossbarHttpBridge->call('wamp.session.get', [$subscriber])['args'][0];
                $clients[$key]['active_schedule_id'] = $Caller->call('eu.hoogstraaten.fishtank.getactivescheduleid.'. $subscriber)['args'][0];
            }
        }
        return view('home', ['clients' => $clients, 'schedules' => $schedules]);
    }
}
