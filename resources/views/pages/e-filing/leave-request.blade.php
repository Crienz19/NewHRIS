@extends('layout.app')

@section('title', 'Leave Request')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <button id="btn-create" class="btn btn-primary btn-sm pull-right" style="margin-bottom: 5px;"><span class="glyphicon glyphicon-plus"></span>&nbsp; Create</button>
                    <table id="leave-table" class="table table-striped table-bordered">
                        <thead>
                            <th>Leave Type</th>
                            <th>Leave Pay</th>
                            <th>Leave Reason</th>
                            <th>Leave From</th>
                            <th>Leave To</th>
                            <th>Time From</th>
                            <th>Time To</th>
                            <th>Recommending Approval</th>
                            <th>Final Approval</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="leave-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white;">&times;</button>
                    <h4 class="modal-title" id="modal-title">Leave View</h4>
                </div>
                <div class="modal-body">
                    <form action="" id="leave-form">
                        <div class="form-group">
                            <label for="leave-type">Leave Type</label>
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <select name="leave-type" class="form-control col-md-6">
                                        <option value="" selected>Select Leave</option>
                                        <option value="SL">Sick Leave</option>
                                        <option value="VL">Vacation Leave</option>
                                        <option value="VL-Half">Vacation Leave - Half Day</option>
                                        <option value="PTO">PTO</option>
                                        <option value="PTO-Half">PTO - Half Day</option>
                                    </select>
                                    <p id="error-leave-type" style="color: red;"></p>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <select name="leave-pay" class="form-control col-md-6">
                                        <option value="" selected>Select Pay</option>
                                        <option value="Without Pay">Without Pay</option>
                                        <option value="With Pay">With Pay</option>
                                    </select>
                                    <p id="error-leave-pay" style="color: red;"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="leave-reason">Reason</label>
                            <textarea style="resize: none;" name="leave-reason" cols="30" rows="10" class="form-control"></textarea>
                            <p id="error-reason" style="color: red;"></p>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="leave-from">From</label>
                                    <input type="date" name="leave-from" class="form-control">
                                    <p id="error-from" style="color: red;"></p>
                                </div>
                                <div class="col-sm-6">
                                    <label for="leave-to">To</label>
                                    <input type="date" name="leave-to" class="form-control">
                                    <p id="error-to" style="color: red;"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="time">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="time" name="time-from" class="form-control">
                                </div>
                                <div class="col-sm-6">
                                    <input type="time" name="time-to" class="form-control">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-theme btn-block" id="btn-action">
                        Send
                    </button>
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
            var dt = $('#leave-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '{{ url("/leaveLoad") }}',
                'dom': 'tp',
                'columns': [
                    { data: 'type', name: 'type' },
                    { data: 'pay_type', name: 'pay_type' },
                    { data: 'reason', name: 'reason' },
                    { data: 'from', name: 'from' },
                    { data: 'to', name: 'to' },
                    { data: 'time_from', name: 'time_from' },
                    { data: 'time_to', name: 'time_to' },
                    { data: 'recommending_approval', name: 'recommending_approval' },
                    { data: 'final_approval', name: 'final_approval' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action' }
                ]
            });

            $('#leave-table tbody').on('click', 'td button', function (){
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');

                switch (data) {
                    case 'edit':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/leaveEdit") }}/' + dataId,
                            method: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                $('#leave-form').attr('action', '{{ url("/leaveUpdate") }}/' + dataId);
                                $('#modal-title').text('Update Leave');
                                $('#btn-action').text('Update');
                                $('select[name=leave-type]').val(response['type']);
                                $('select[name=leave-pay]').val(response['pay_type']);
                                $('textarea[name=leave-reason]').val(response['reason']);
                                $('input[name=leave-from]').val(response['from']);
                                $('input[name=leave-to]').val(response['to']);
                                $('input[name=time-from]').val(response['time_from']);
                                $('input[name=time-to]').val(response['time_to']);

                                if(response['type'] === 'VL-Half' || response['type'] === 'PTO-Half') {
                                    $('#time').show();
                                } else {
                                    $('#time').hide();
                                }
                                $('#leave-modal').modal('show');
                            }
                        });
                        break;

                    case 'remove':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/leaveDelete") }}/' + dataId,
                            method: 'post',
                            dataType: 'json',
                            success: function(response) {
                                dt.api().ajax.reload();
                            }
                        });
                        break;
                }
            });

            $('#btn-create').click(function() {
                $('#leave-form').attr('action', '{{ url("/leaveStore") }}');
                $('#leave-form')[0].reset();
                $('#modal-title').text('Create Leave');
                $('#btn-action').text('Send Leave');
                $('#time').hide();
                $('#leave-modal').modal('show');
            });

            $('select[name=leave-type]').click(function() {
                if($(this).val() === 'VL-Half' || $(this).val() === 'PTO-Half') {
                    $('#time').show();
                } else {
                    $('#time').hide();
                }
            });

            $('#btn-action').click(function() {
                var formData = new FormData($('#leave-form')[0]);
                var url = $('#leave-form').attr('action');

                $.ajax({
                    type: 'ajax',
                    url: url,
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function(response) {
                        $('#btn-action').prop('disabled', true);
                    },
                    success: function(response) {
                        alert(response['message']);

                        dt.api().ajax.reload();
                        $('#leave-modal').modal('hide');

                        $('#btn-action').prop('disabled', false);
                    },
                    error: function(response) {
                        var error = response.responseJSON.errors;

                        $('#error-leave-type').html(error['leave-type']);
                        $('#error-leave-pay').html(error['leave-pay']);
                        $('#error-reason').html(error['leave-reason']);
                        $('#error-from').html(error['leave-from']);
                        $('#error-to').html(error['leave-to']);

                        $('#btn-action').prop('disabled', false);
                    }
                });
            });
        })
    </script>
@endsection