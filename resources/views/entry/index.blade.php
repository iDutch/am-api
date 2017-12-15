@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Entries</div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 32px;">#:</th>
                                <th>Time:</th>
                                <th style="width: 75px;">Red:</th>
                                <th style="width: 75px;">Green:</th>
                                <th style="width: 75px;">Blue:</th>
                                <th style="width: 75px;">Warmwhite:</th>
                                <th style="width: 75px;">Coldwhite:</th>
                                <th style="width: 150px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entries as $entry)
                                <tr>
                                    <td>{{ $entry->id }}</td>
                                    <td>{{ $entry->time->format('H:i') }}</td>
                                    <td>{{ $entry->red }}%</td>
                                    <td>{{ $entry->green }}%</td>
                                    <td>{{ $entry->blue }}%</td>
                                    <td>{{ $entry->warmwhite }}%</td>
                                    <td>{{ $entry->coldwhite }}%</td>
                                    <td>
                                        <a class="btn btn-default" href="{{ route('entry.edit', ['schedule_id' => $schedule_id, 'id' => $entry->id]) }}">
                                            Edit
                                        </a>
                                        <a class="btn btn-danger" href="#">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
