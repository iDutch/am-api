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
