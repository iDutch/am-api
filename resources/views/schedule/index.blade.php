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
                                <th style="width: 275px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)
                                <tr>
                                    <td><input class="check" type="checkbox" name="id[]" value="{{ $schedule->id }}"></td>
                                    <td>{{ $schedule->name }}</td>
                                    <td>{{ $schedule->entries->count() }}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{ route('schedule.entries', ['schedule_id' => $schedule->id]) }}">
                                            Show entries
                                        </a>
                                        <a class="btn btn-default" href="{{ route('schedule.edit', ['id' => $schedule->id]) }}">
                                            Edit
                                        </a>
                                        <a class="delete btn btn-danger" href="#" data-id="{{ $schedule->id }}">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <a class="btn btn-primary pull-left" href="{{ route('schedule.create') }}">
                                        Add schedule
                                    </a>
                                    <button disabled id="mass-delete" class="btn btn-danger pull-right">
                                        Delete selected
                                    </button>
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
                <form class="form-horizontal" method="POST" action="{{ route('schedule.delete') }}">
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
                        Are you sure you want to delete this schedule? All entries will be deleted with it!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-danger" value="Delete schedule">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteMulti" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" method="POST" action="{{ route('schedule.delete') }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <div id="input-placeholder"></div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete these schedules? All entries will be deleted with them!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-danger" value="Delete schedule">
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
        $('#mass-delete').on('click', function (e) {
            e.preventDefault();
            var ids = [];
            $('.check:checked').each(function () {
                $('#input-placeholder').append('<input type="hidden" name="id[]" value="' + $(this).val() + '">')
            });
            $('#schedule-ids').val(ids.join());
            $('#deleteMulti').modal({"backdrop": "static"});
        });

        $('#mass-delete').prop('disabled', true);
        $('.check').on('click', function () {
            $('#mass-delete').prop('disabled', true);
            $('.check:checked').each(function () {
                $('#mass-delete').prop('disabled', false);
            });
        })
    </script>
@endsection
