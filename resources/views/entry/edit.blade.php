@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit entry</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('entry.update', ['schedule_id' => $schedule_id, 'id' => $entry->id]) }}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="form-group{{ $errors->has('time') ? ' has-error' : '' }}">
                            <label for="time" class="col-md-4 control-label">Time</label>
                            <div class="col-md-6">
                                <input id="time" type="time" class="form-control" name="time" value="{{ $entry->time->format('H:i') }}" required autofocus>
                                @if ($errors->has('time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('time') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('red') ? ' has-error' : '' }}">
                            <label for="red" class="col-md-4 control-label">Red</label>
                            <div class="col-md-6">
                                <input
                                        id="red"
                                        type="text"
                                        name="red"
                                        data-slider-id='redSlider'
                                        data-slider-ticks="[0, 100]"
                                        data-slider-ticks-labels='["0%", "100%"]'
                                        data-slider-min="1"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="{{ $entry->red }}"
                                        data-slider-tooltip="show"
                                >
                                @if ($errors->has('time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('red') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('green') ? ' has-error' : '' }}">
                            <label for="green" class="col-md-4 control-label">Green</label>
                            <div class="col-md-6">
                                <input
                                        id="green"
                                        type="text"
                                        name="green"
                                        data-slider-id='greenSlider'
                                        data-slider-ticks="[0, 100]"
                                        data-slider-ticks-labels='["0%", "100%"]'
                                        data-slider-min="1"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="{{ $entry->green }}"
                                        data-slider-tooltip="show"
                                >
                                @if ($errors->has('green'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('green') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('blue') ? ' has-error' : '' }}">
                            <label for="blue" class="col-md-4 control-label">Blue</label>
                            <div class="col-md-6">
                                <input
                                        id="blue"
                                        type="text"
                                        name="blue"
                                        data-slider-id='blueSlider'
                                        data-slider-ticks="[0, 100]"
                                        data-slider-ticks-labels='["0%", "100%"]'
                                        data-slider-min="1"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="{{ $entry->blue }}"
                                        data-slider-tooltip="show"
                                >
                                @if ($errors->has('blue'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('blue') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('warmwhite') ? ' has-error' : '' }}">
                            <label for="warmwhite" class="col-md-4 control-label">Warmwhite</label>
                            <div class="col-md-6">
                                <input
                                        id="warmwhite"
                                        type="text"
                                        name="warmwhite"
                                        data-slider-id='warmwhiteSlider'
                                        data-slider-ticks="[0, 100]"
                                        data-slider-ticks-labels='["0%", "100%"]'
                                        data-slider-min="1"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="{{ $entry->warmwhite }}"
                                        data-slider-tooltip="show"
                                >
                                @if ($errors->has('time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('warmwhite') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('coldwhite') ? ' has-error' : '' }}">
                            <label for="coldwhite" class="col-md-4 control-label">Coldwhite</label>
                            <div class="col-md-6">
                                <input
                                        id="coldwhite"
                                        type="text"
                                        name="coldwhite"
                                        data-slider-id='coldwhiteSlider'
                                        data-slider-ticks="[0, 100]"
                                        data-slider-ticks-labels='["0%", "100%"]'
                                        data-slider-min="1"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="{{ $entry->coldwhite }}"
                                        data-slider-tooltip="show"
                                >
                                @if ($errors->has('coldwhite'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('coldwhite') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>

                                <a class="btn btn-default" href="{{ route('schedule.entries', ['schedule_id' => $schedule_id]) }}">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $("#red").slider({
            formatter: function(value) {
                return value + '%';
            }
        });
        $("#green").slider({
            formatter: function(value) {
                return value + '%';
            }
        });
        $("#blue").slider({
            formatter: function(value) {
                return value + '%';
            }
        });
        $("#warmwhite").slider({
            formatter: function(value) {
                return value + '%';
            }
        });
        $("#coldwhite").slider({
            formatter: function(value) {
                return value + '%';
            }
        });

        axios.get('/api/user')
            .then(response => {
                console.log(response.data);
            });

        axios.get('/api/schedules')
            .then(response => {
                console.log(response.data);
            });
    </script>
@endsection