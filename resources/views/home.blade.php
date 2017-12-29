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
                                                <div class="btn-group">
                                                    <button disabled type="button" class="btn btn-default time"></button>
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="cycle" data-speed="250" href="#">4x</a></li>
                                                        <li><a class="cycle" data-speed="125" href="#">8x</a></li>
                                                        <li><a class="cycle" data-speed="63" href="#">16x</a></li>
                                                        <li><a class="cycle" data-speed="31" href="#">32x</a></li>
                                                    </ul>
                                                </div>
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
            $('.device').each(function () {
                var device_id = $(this).attr('id');
                var time = $(this).find('.time');
                var select = $(this).find('.schedule');
                var cycle = $(this).find('.cycle');
                console.log(cycle);
                cycle.on('click', function (e) {
                   e.preventDefault();
                   session.call('eu.hoogstraaten.fishtank.cycleschedule.'+ device_id, [$(this).data('speed')]);
                });
                select.on('change', function () {
                   session.call('eu.hoogstraaten.fishtank.setschedule.'+ device_id, [$(this).val()]);
                });
                session.subscribe('eu.hoogstraaten.fishtank.time.'+ device_id, function (args) {
                    var t = window.moment(args[0]);
                    time.html(t.format('HH:mm:ss'));
                });
            });
        };

        connection.onclose = function (reason, details) {
            console.log("Connection lost:", reason, details);
        };

        connection.open();
    </script>
@endsection
