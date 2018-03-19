<?php

namespace App\Http\Controllers;

use App\Schedule;
use iDutch\CrossbarHttpBridge\HttpBridge\HttpBridge;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules =  Schedule::where('user_id', Auth::id())->get();

        $HttpBridge = new HttpBridge();
        $Caller = $HttpBridge->createCaller('https', 'cb.hoogstraaten.eu', 443, '/call', config('app.crossbar_http_bridge_caller_key'), config('app.crossbar_http_bridge_caller_secret'), null, false);

        $subscription = $Caller->call('wamp.subscription.lookup', ['eu.hoogstraaten.fishtank.publish']);
        $clients = [];

        if (!is_null($subscription['args'][0])) {
            $subscribers = $Caller->call('wamp.subscription.list_subscribers', [$subscription['args'][0]]);
            foreach ($subscribers['args'][0] as $key => $subscriber) {
                $clients[$key] = $Caller->call('wamp.session.get', [$subscriber])['args'][0];
                $clients[$key]['active_schedule_id'] = $Caller->call('eu.hoogstraaten.fishtank.getactivescheduleid.'. $subscriber)['args'][0];
            }
        }
        return view('home', ['clients' => $clients, 'schedules' => $schedules]);
    }
}
