@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Devices</div>
                <div class="panel-body">
                    <div class="panel panel-default col-md-6">
                        <div class="panel-heading">Aquarium Lights</div>
                        <div class="panel-body">
                            Active Schedule: <select class="form-control coll-md-" name="schedule">
                                <option value="1">Default</option>
                            </select><br>

                            Time: 19:43
                        </div>
                    </div>
                    <div class="panel panel-default col-md-6">
                        <div class="panel-heading">Aquarium Lights</div>
                        <div class="panel-body">
                            Active Schedule: <select class="form-control coll-md-" name="schedule">
                                <option value="1">Default</option>
                            </select><br>

                            Time: 19:43
                        </div>
                    </div>
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
            console.log("frontend connected");
        };

        connection.onclose = function (reason, details) {
            console.log("Connection lost:", reason, details);
        };

        connection.open();
    </script>
@endsection
