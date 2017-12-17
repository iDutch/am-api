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
                                    <td><input type="checkbox" name="id[]" value="{{ $entry->id }}"></td>
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
                                        <a class="delete btn btn-danger" href="#" data-id="{{ $entry->id }}">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <a class="btn btn-primary" href="{{ route('entry.create', ['schedule_id' => $schedule_id]) }}">
                                        Add entry
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
@section('modals')
    <div class="modal fade" id="deleteSingle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" method="POST" action="{{ route('entry.delete', ['schedule_id' => $schedule_id]) }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input id="schedule-id" type="hidden" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this entry?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-danger" value="Delete entry">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('.delete').on('click', function (e) {
            e.preventDefault();
            $('#schedule-id').val($(this).data('id'));
            $('#deleteSingle').modal({"backdrop": "static"});
        });
    </script>
@endsection
