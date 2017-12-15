@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Schedules</div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 32px;">#:</th>
                                <th>Name:</th>
                                <th style="width: 75px;">Entries:</th>
                                <th style="width: 200px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->id }}</td>
                                    <td>{{ $schedule->name }}</td>
                                    <td>{{ $schedule->entries->count() }}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{ route('schedule.entries', ['schedule_id' => $schedule->id]) }}">
                                            Show entries
                                        </a>
                                        <a class="btn btn-default" href="{{ route('schedule.edit', ['id' => $schedule->id]) }}">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <a class="btn btn-success" href="{{ route('schedule.create') }}">
                                        Add schedule
                                    </a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
