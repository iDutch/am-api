<?php

namespace App\Http\Controllers;

use iDutch\CrossbarHttpBridge\HttpBridge\HttpBridge;
use Illuminate\Http\Request;

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
        $HttpBridge = new HttpBridge();
        $Caller = $HttpBridge->createCaller('https', 'cb.hoogstraaten.eu', 443, '/call', config('app.crossbar_http_bridge_caller_key'), config('app.crossbar_http_bridge_caller_secret'), null, false);

        $subscription = $Caller->call('wamp.subscription.lookup', ['eu.hoogstraaten.fishtank.publish']);
        $subscribers = $Caller->call('wamp.subscription.list_subscribers', [$subscription['args'][0]]);
        var_dump($subscribers);

        return view('home');
    }
}
