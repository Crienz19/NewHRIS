@extends('layout.app')

@section('title', 'Trip Request')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <button id="btn-create" class="btn btn-primary btn-sm pull-right" style="margin-bottom: 5px;"><span class="glyphicon glyphicon-plus"></span>&nbsp; Create</button>
                    <table id="trip-table" class="table table-striped table-bordered">
                        <thead>
                        <th>Date From</th>
                        <th>Date To</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Destination From</th>
                        <th>Destination To</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="ob-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white;">&times;</button>
                    <h4 class="modal-title" id="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form id="ob-form" action="">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="date-from">Date From: </label>
                                    <input type="date" name="date-from" class="form-control">
                                    <span id="date-from-error" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="date-to">Date To: </label>
                                    <input type="date" name="date-to" class="form-control">
                                    <span id="date-to-error" style="color: red;"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="time-in">Time In: </label>
                                    <input type="time" name="time-in" class="form-control">
                                    <span id="time-in-error" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="time-out">Time Out: </label>
                                    <input type="time" name="time-out" class="form-control">
                                    <span id="time-out-error" style="color: red;"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="dest-from">Destination From: </label>
                                    <input type="text" name="dest-from" class="form-control">
                                    <span id="dest-from-error" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="dest-to">Destination To: </label>
                                    <input type="text" name="dest-to" class="form-control">
                                    <span id="dest-to-error" style="color: red;"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="purpose">Purpose of the Trip</label>
                                    <textarea style="resize: none;" name="purpose" cols="30" rows="10" class="form-control"></textarea>
                                    <span id="purpose-error" style="color: red;"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-theme btn-block" id="btn-action">Send</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
@endsection

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            var dt = $('#trip-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '{{ url("/tripLoad") }}',
                'dom': 'tp',
                'columns': [
                    { data: 'date_from', name: 'date_from' },
                    { data: 'date_to', name: 'date_to' },
                    { data: 'time_in', name: 'time_in' },
                    { data: 'time_out', name: 'time_out' },
                    { data: 'destination_from', name: 'destination_from' },
                    { data: 'destination_to', name: 'destination_to' },
                    { data: 'purpose', name: 'purpose' },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action' }
                ]
            });

            $('#trip-table tbody').on('click', 'td button', function (){
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');

                switch (data) {
                    case 'edit':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/tripEdit") }}/' + dataId,
                            method: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                $('#ob-form').attr('action', '{{ url("/tripUpdate") }}/' + dataId);
                                $('#modal-title').text('Update Official Business Trip');
                                $('#btn-action').text('Update Trip');
                                $('input[name=date-from]').val(response['date_from']);
                                $('input[name=date-to]').val(response['date_to']);
                                $('input[name=time-in]').val(response['time_in']);
                                $('input[name=time-out]').val(response['time_out']);
                                $('input[name=dest-from]').val(response['destination_from']);
                                $('input[name=dest-to]').val(response['destination_to']);
                                $('textarea[name=purpose]').val(response['purpose']);

                                $('#ob-modal').modal('show');
                            }
                        });
                        break;

                    case 'remove':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/tripDelete") }}/' + dataId,
                            method: 'post',
                            dataType: 'json',
                            success: function(response) {
                                dt.api().ajax.reload();
                                console.log(response);
                            }
                        });
                        break;
                }
            });

            $('#btn-create').click(function() {
                $('#ob-form').attr('action', '{{ url("/tripStore") }}');
                $('#ob-form')[0].reset();
                $('#modal-title').text('Create Official Business Trip');
                $('#btn-action').text('Send Trip');
                $('#ob-modal').modal('show');
            });

            $('#btn-action').click(function() {
                var formData = new FormData($('#ob-form')[0]);
                var url = $('#ob-form').attr('action');

                $.ajax({
                    type: 'ajax',
                    url: url,
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#btn-action').prop('disabled', true);
                    },
                    success: function(response) {
                        alert(response['message']);

                        dt.api().ajax.reload();
                        $('#ob-modal').modal('hide');

                        $('#btn-action').prop('disabled', false);
                    },
                    error: function(response) {
                        $('#btn-action').prop('disabled', false);
                        var error = response.responseJSON.errors;

                        $('#date-from-error').html(error['date-from']);
                        $('#date-to-error').html(error['date-to']);
                        $('#time-in-error').html(error['time-in']);
                        $('#time-out-error').html(error['time-out']);
                        $('#dest-from-error').html(error['dest-from']);
                        $('#dest-to-error').html(error['dest-to']);
                        $('#purpose-error').html(error['purpose']);
                    }
                });
            });
        })
    </script>
@endsection