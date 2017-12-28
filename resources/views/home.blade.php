@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Devices</div>
                <div id="devices-container" class="panel-body">
                    @foreach ($clients as $client)
                        <div id="{{ $client['session'] }}" class="device card col-md-6">
                            <div class="card-body">
                                <h4 class="card-title">{{ $client['authid'] }}</h4>
                                <p class="card-text">
                                    <select class="form-control coll-md-" name="schedule">
                                        <option value="1">Default</option>
                                    </select>
                                </p>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default time"></button>
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">4x</a></li>
                                        <li><a href="#">8x</a></li>
                                        <li><a href="#">16x</a></li>
                                        <li><a href="#">32x</a></li>
                                    </ul>
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
                var time = $(this).find('.time');
                session.subscribe('eu.hoogstraaten.fishtank.time.'+ $(this).attr('id'), function (args) {
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
