@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Devices</div>
                <div id="devices-container" class="panel-body">
                    @foreach ($clients as $client)
                        <div id="{{ $client['session'] }}" class="device col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">{{ $client['authid'] }}</h3>
                                </div>
                                <div class="panel-body">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label for="schedule" class="col-md-4 control-label">Active Schedule:</label>
                                            <div class="col-md-8">
                                                <select class="form-control schedule" name="schedule">
                                                    @foreach($schedules as $schedule)
                                                        <option {{ $schedule->id === $client['active_schedule_id'] ? "selected" : "" }} value="{{ $schedule->id  }}">{{ $schedule->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="schedule" class="col-md-4 control-label">Time:</label>
                                            <div class="col-md-8">
                                                <button disabled style="width: 85px;" type="button" class="btn btn-default time"></button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="schedule" class="col-md-4 control-label">Channel values:</label>
                                            <div class="col-md-8">
                                                <button id="{{ $client['session'] }}redLed" class="btn btn-danger" data-toggle="button"><i class="redLed"></i></button>
                                                <button id="{{ $client['session'] }}greenLed" class="btn btn-success" data-toggle="button"><i class="greenLed"></i></button>
                                                <button id="{{ $client['session'] }}blueLed" class="btn btn-primary" data-toggle="button"><i class="blueLed"></i></button>
                                                <button id="{{ $client['session'] }}wwhiteLed" class="btn btn-warning" data-toggle="button"><i class="wwhiteLed"></i></button>
                                                <button id="{{ $client['session'] }}cwhiteLed" class="btn btn-default" data-toggle="button"><i class="cwhiteLed"></i></button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input
                                                        id="{{ $client['session'] }}red"
                                                        type="text"
                                                        name="red"
                                                        data-slider-id='redSlider'
                                                        data-slider-ticks="[0, {{ config('app.pwm_range') }}]"
                                                        {{--data-slider-ticks-labels='["0%", "100%"]'--}}
                                                        data-slider-min="0"
                                                        data-slider-max="{{ config('app.pwm_range') }}"
                                                        data-slider-step="1"
                                                        data-slider-value="0"
                                                        data-slider-tooltip="show"
                                                        data-slider-enabled="false"
                                                >
                                                <span class="pull-left">0%</span>
                                                <span class="pull-right">100%</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input
                                                        id="{{ $client['session'] }}green"
                                                        type="text"
                                                        name="green"
                                                        data-slider-id='greenSlider'
                                                        data-slider-ticks="[0, {{ config('app.pwm_range') }}]"
                                                        {{--data-slider-ticks-labels='["0%", "100%"]'--}}
                                                        data-slider-min="0"
                                                        data-slider-max="{{ config('app.pwm_range') }}"
                                                        data-slider-step="1"
                                                        data-slider-value="0"
                                                        data-slider-tooltip="show"
                                                        data-slider-enabled="false"
                                                >
                                                <span class="pull-left">0%</span>
                                                <span class="pull-right">100%</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input
                                                        id="{{ $client['session'] }}blue"
                                                        type="text"
                                                        name="blue"
                                                        data-slider-id='blueSlider'
                                                        data-slider-ticks="[0, {{ config('app.pwm_range') }}]"
                                                        {{--data-slider-ticks-labels='["0%", "100%"]'--}}
                                                        data-slider-min="0"
                                                        data-slider-max="{{ config('app.pwm_range') }}"
                                                        data-slider-step="1"
                                                        data-slider-value="0"
                                                        data-slider-tooltip="show"
                                                        data-slider-enabled="false"
                                                        
                                                >
                                                <span class="pull-left">0%</span>
                                                <span class="pull-right">100%</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input
                                                        id="{{ $client['session'] }}wwhite"
                                                        type="text"
                                                        name="wwhite"
                                                        data-slider-id='wwhiteSlider'
                                                        data-slider-ticks="[0, {{ config('app.pwm_range') }}]"
                                                        {{--data-slider-ticks-labels='["0%", "100%"]'--}}
                                                        data-slider-min="0"
                                                        data-slider-max="{{ config('app.pwm_range') }}"
                                                        data-slider-step="1"
                                                        data-slider-value="0"
                                                        data-slider-tooltip="show"
                                                        data-slider-enabled="false"
                                                >
                                                <span class="pull-left">0%</span>
                                                <span class="pull-right">100%</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input
                                                        id="{{ $client['session'] }}cwhite"
                                                        type="text"
                                                        name="cwhite"
                                                        data-slider-id='cwhiteSlider'
                                                        data-slider-ticks="[0, {{ config('app.pwm_range') }}]"
                                                        {{--data-slider-ticks-labels='["0%", "100%"]'--}}
                                                        data-slider-min="0"
                                                        data-slider-max="{{ config('app.pwm_range') }}"
                                                        data-slider-step="1"
                                                        data-slider-value="0"
                                                        data-slider-tooltip="show"
                                                        data-slider-enabled="false"
                                                >
                                                <span class="pull-left">0%</span>
                                                <span class="pull-right">100%</span>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        let user = 'App';
        let key = '789d0977830cb074909aebbd281845d65ca3b8052510911c73d317f5ab9c036a';

        let PWMRange = parseInt('{{ config('app.pwm_range') }}');
        let percentFactor = PWMRange / 100;

        // This challenge callback will authenticate our frontend component
        function onchallenge (session, method, extra) {
            console.log("onchallenge", method, extra);
            if (method === "wampcra") {
                console.log("authenticating via '" + method + "' and challenge '" + extra.challenge + "'");
                return autobahn.auth_cra.sign(key, extra.challenge);
            } else {
                throw "don't know how to authenticate using '" + method + "'";
            }
        }

        let connection = new window.autobahn.Connection({
            url: 'wss://cb.hoogstraaten.eu/ws',
            realm: 'eu.hoogstraaten.fishtank',
            authid: user,
            authmethods: ["wampcra"],
            onchallenge: onchallenge
        });

        connection.onopen = function (session) {
            let time = {};
            let select = {};
            let channelvalues = {};
            let channelsliders = {};
            $('.device').each(function () {
                let device_id = $(this).attr('id');
                time[device_id] = $(this).find('.time');
                select[device_id] = $(this).find('.schedule');
                channelvalues[device_id] = {
                    "redLed": $(this).find('.redLed'),
                    "greenLed": $(this).find('.greenLed'),
                    "blueLed": $(this).find('.blueLed'),
                    "wwhiteLed": $(this).find('.wwhiteLed'),
                    "cwhiteLed": $(this).find('.cwhiteLed'),
                };
                channelsliders[device_id] = {
                    "redLed": $(this).find('#' + device_id + 'red'),
                    "greenLed": $(this).find('#' + device_id + 'green'),
                    "blueLed": $(this).find('#' + device_id + 'blue'),
                    "wwhiteLed": $(this).find('#' + device_id + 'wwhite'),
                    "cwhiteLed": $(this).find('#' + device_id + 'cwhite'),
                };
                select[device_id].on('change', function () {
                   session.call('eu.hoogstraaten.fishtank.setschedule.'+ device_id, [$(this).val()]);
                });
                session.subscribe('eu.hoogstraaten.fishtank.time.'+ device_id, function (args) {
                    let t = window.moment(args[0]);
                    time[device_id].html(t.format('HH:mm:ss'));
                });
                session.subscribe('eu.hoogstraaten.fishtank.channelvalues.'+ device_id, function (args) {
                    let data = args[0];
                    for (let i in data) {
                        channelvalues[device_id][i].html(parseInt(data[i]));
                        channelsliders[device_id][i].data('slider').setValue(data[i]);
                    }
                });


                $("#" + device_id + "red").slider({
                    formatter: function(value) {
                        return (value / percentFactor) + '%';
                    },
                    focus: true
                }).on('slide', function () {
                    session.call('eu.hoogstraaten.fishtank.setledvalue.'+ device_id, ['red', parseFloat($(this).val())]);
                });

                $("#" + device_id + "green").slider({
                    formatter: function(value) {
                        return (value / percentFactor) + '%';
                    },
                    focus: true
                }).on('slide', function () {
                    session.call('eu.hoogstraaten.fishtank.setledvalue.'+ device_id, ['green', parseFloat($(this).val())]);
                });

                $("#" + device_id + "blue").slider({
                    formatter: function(value) {
                        return (value / percentFactor) + '%';
                    },
                    focus: true
                }).on('slide', function () {
                    session.call('eu.hoogstraaten.fishtank.setledvalue.'+ device_id, ['blue', parseFloat($(this).val())]);
                });

                $("#" + device_id + "wwhite").slider({
                    formatter: function(value) {
                        return (value / percentFactor) + '%';
                    },
                    focus: true
                }).on('slide', function () {
                    session.call('eu.hoogstraaten.fishtank.setledvalue.'+ device_id, ['wwhite', parseFloat($(this).val())]);
                });

                $("#" + device_id + "cwhite").slider({
                    formatter: function(value) {
                        return (value / percentFactor) + '%';
                    },
                    focus: true
                }).on('slide', function () {
                    session.call('eu.hoogstraaten.fishtank.setledvalue.'+ device_id, ['cwhite', parseFloat($(this).val())]);
                });

                let toggles = {};
                for (let i in channelvalues[device_id]) {
                    toggles[i] = false;
                    channelvalues[device_id][i].parent().on('click', function(e) {
                        e.preventDefault();
                        toggles[i] = !toggles[i];
                        session.call('eu.hoogstraaten.fishtank.setchanneloverride.'+ device_id, [i, toggles[i]]);
                        if (toggles[i]) {
                            channelsliders[device_id][i].slider("enable").data('slider').setValue(parseFloat(channelvalues[device_id][i].html()));
                        } else {
                            channelsliders[device_id][i].slider("disable").data('slider').setValue(parseFloat(channelvalues[device_id][i].html()));
                        }
                    });
                }
            });
        };

        connection.onclose = function (reason, details) {
            console.log("Connection lost:", reason, details);
        };

        connection.open();
    </script>
@endsection
