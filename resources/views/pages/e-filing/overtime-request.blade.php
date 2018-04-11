@extends('layout.app')

@section('title', 'Overtime Request')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <button id="btn-create" class="btn btn-primary btn-sm pull-right" style="margin-bottom: 5px;"><span class="glyphicon glyphicon-plus"></span>&nbsp; Create</button>
                    <table id="ot-table" class="table table-striped table-bordered">
                        <thead>
                        <th>Date</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Action</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="ot-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white;">&times;</button>
                    <h4 class="modal-title" id="modal-title">Leave View</h4>
                </div>
                <div class="modal-body">
                    <form action="" id="ot-form">
                        <div class="form-group">
                            <label for="ot-date">Date</label>
                            <input type="date" name="ot-date" id="ot-date" class="form-control">
                            <p id="error-date" style="color: red; display: none;"></p>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="ot-from">From</label>
                                    <input type="time" name="ot-from" id="ot-from" class="form-control">
                                    <p id="error-from" style="color: red; display: none;"></p>
                                </div>
                                <div class="col-sm-6">
                                    <label for="ot-to">To</label>
                                    <input type="time" name="ot-to" id="ot-to" class="form-control">
                                    <p id="error-to" style="color: red; display: none;"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ot-reason">Reason</label>
                            <textarea style="resize: none;" name="ot-reason" id="ot-reason" cols="30" rows="10" class="form-control"></textarea>
                            <p id="error-reason" style="color: red; display: none;"></p>
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

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="view-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modal-title">Overtime View</h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Date</td>
                            <td id="date">klsjdflkjdlks</td>
                        </tr>
                        <tr>
                            <td>From</td>
                            <td id="from">kdjlsfkjskdlfj</td>
                        </tr>
                        <tr>
                            <td>To</td>
                            <td id="to">kdjlsfkjskdlfj</td>
                        </tr>
                        <tr>
                            <td>Reason</td>
                            <td id="reason">kdjlsfkjskdlfj</td>
                        </tr>
                        <tr>
                            <td>Remarks</td>
                            <td id="remarks">kdsfjklsdjf</td>
                        </tr>
                        </tbody>
                    </table>
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
            var dt = $('#ot-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '{{ url("/overtimeLoad") }}',
                'dom': 'tp',
                'columns': [
                    { data: 'date', name: 'date' },
                    { data: 'from', name: 'from' },
                    { data: 'to', name: 'to' },
                    { data: 'reason', name: 'reason' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action' }
                ]
            });

            $('#ot-table tbody').on('click', 'td button', function (){
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');

                switch (data) {
                    case 'view':
                        $.ajax({
                            type: 'ajax',
                            url: `{{ url("/overtimeEdit") }}/${dataId}`,
                            method: 'get',
                            dataType: 'json',
                            success: function(response) {
                                $('#date').html(response['date']);
                                $('#from').html(response['from']);
                                $('#to').html(response['to']);
                                $('#reason').html(response['reason']);
                                $('#remarks').html(response['remarks']);

                                $('view-modal').modal('show');
                            }
                        });
                        break;

                    case 'edit':
                        $.ajax({
                            type: 'ajax',
                            url: `{{ url("/overtimeEdit") }}/${dataId}`,
                            method: 'get',
                            dataType: 'json',
                            success: function(response) {
                                $('#ot-form').attr('action', `{{ url("/overtimeUpdate") }}/${dataId}`);
                                $('#modal-title').text('Update Overtime');
                                $('#btn-action').text('Update Overtime');
                                $('input[name=ot-date]').val(response['date']);
                                $('input[name=ot-from]').val(response['from']);
                                $('input[name=ot-to]').val(response['to']);
                                $('textarea[name=ot-reason]').val(response['reason']);

                                $('#ot-modal').modal('show');
                            }
                        });
                        break;

                    case 'remove':
                        $.ajax({
                            type: 'ajax',
                            url: `{{ url("/overtimeDelete") }}/${dataId}`,
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
                $('#ot-form').attr('action', '{{ url("/overtimeStore") }}');
                $('#ot-form')[0].reset();
                $('#modal-title').text('Create Overtime');
                $('#btn-action').text('Send Overtime');
                $('#ot-modal').modal('show');
            });

            $('#btn-action').click(function() {
                var formData = new FormData($('#ot-form')[0]);
                var url = $('#ot-form').attr('action');

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
                        $('#btn-action').prop('disabled', false);

                        dt.api().ajax.reload();
                        $('#ot-modal').modal('hide');
                    },
                    error: function(response) {
                        var error = response.responseJSON.errors;

                        $('#error-date').html(error['ot-date']).show();
                        $('#error-from').html(error['ot-from']).show();
                        $('#error-to').html(error['ot-to']).show();
                        $('#error-reason').html(error['ot-reason']).show();

                        $('#btn-action').prop('disabled', false);
                    }
                });
            });
        })
    </script>
@endsection