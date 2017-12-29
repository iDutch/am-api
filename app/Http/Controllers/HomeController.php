<?php

namespace App\Http\Controllers;

use App\Schedule;
use iDutch\CrossbarHttpBridge\HttpBridge\HttpBridge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $subscribers = $Caller->call('wamp.subscription.list_subscribers', [$subscription['args'][0]]);

        $clients = [];
        $i = 0;
        foreach ($subscribers['args'] as $subscriber) {
            $clients[$i] = $Caller->call('wamp.session.get', [$subscriber[0]])['args'][0];
            $clients[$i]['active_schedule_id'] = $Caller->call('eu.hoogstraaten.fishtank.getactivescheduleid.'. $subscriber[0])['args'][0];
            $i++;
        }
        return view('home', ['clients' => $clients, 'schedules' => $schedules]);
    }
}
