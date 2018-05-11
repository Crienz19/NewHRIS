@extends('layout.app')

@section('title', 'Notice Slip')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <button id="btn-create" class="btn btn-primary btn-sm pull-right" style="margin-bottom: 5px;"><span class="glyphicon glyphicon-plus"></span>&nbsp; Create</button>
                    <table id="notice-table" class="table table-striped table-bordered">
                        <thead>
                            <th>Nature of Action</th>
                            <th>Date</th>
                            <th>Time-In</th>
                            <th>Time-Out</th>
                            <th>Explantion</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="notice-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white;">&times;</button>
                    <h4 class="modal-title" id="modal-title">Notice Slip View</h4>
                </div>
                <div class="modal-body">
                    <form action="" id="notice-form">
                        <div class="form-group">
                            <label for="notice-nature">Nature of Action</label>
                            <select name="notice-nature" id="notice-nature" class="form-control">
                                <option value="Failure to Time-In/Time-Out">Failure to Time-In/Time-Out</option>
                                <option value="Tardiness">Tardiness</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notice-date">Date</label>
                            <input type="date" name="notice-date" id="notice-date" class="form-control">
                            <p id="error-date" style="color: red; display: none"></p>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="notice-In">Time-In</label>
                                    <input type="time" name="notice-In" id="notice-In" class="form-control">
                                    <p id="error-time-in" style="color: red; display: none"></p>
                                </div>
                                <div class="col-sm-6" id="tardiness">
                                    <label for="notice-Out">Time-Out</label>
                                    <input type="time" name="notice-Out" id="notice-Out" class="form-control">
                                    <p id="error-time-out" style="color: red; display: none"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="notice-explanation">Explanation</label>
                            <textarea name="notice-explanation" id="notice-explanation" cols="30" rows="10" class="form-control" placeholder="Type your Explanation..."></textarea>
                            <p id="error-explanation" style="color: red; display: none"></p>
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
            var dt = $('#notice-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '{{ url("/noticeLoad") }}',
                'dom': 'tp',
                'columns': [
                    { data: 'nature', name: 'nature' },
                    { data: 'date', name: 'date' },
                    { data: 'time_in', name: 'time_in' },
                    { data: 'time_out', name: 'time_out' },
                    { data: 'explanation', name: 'explanation' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action' },
                ]
            });

            $('#notice-table tbody').on('click', 'td button', function (){
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');

                switch (data) {
                    case 'edit':
                        $.ajax({
                            type: 'ajax',
                            url: `{{ url('/noticeEdit') }}/${dataId}`,
                            method: 'get',
                            dataType: 'json',
                            success: function(response) {
                                $('#notice-form').attr('action', `{{ url('/noticeUpdate') }}/${dataId}`);
                                $('#btn-action').text('Update');
                                $('select[name=notice-nature]').val(response['nature']);
                                $('input[name=notice-date]').val(response['date']);
                                $('input[name=notice-In]').val(response['time_in']);
                                $('input[name=notice-Out]').val(response['time_out']);
                                $('textarea[name=notice-explanation]').val(response['explanation']);
                                $('#notice-modal').modal('show');
                            }
                        });
                        break;

                    case 'remove':
                        $.ajax({
                            type: 'ajax',
                            url: `{{ url('/noticeDelete') }}/${dataId}`,
                            method: 'post',
                            dataType: 'json',
                            success: function(response) {
                                dt.api().ajax.reload();
                                alert('Notice Slip Deleted');
                            }
                        });
                        break;
                }
            });

            $('#btn-create').click(function() {
                $('#notice-form').attr('action', '{{ url("/noticeStore") }}');
                $('#btn-action').text('Send');
                $('input[name=notice-date]').val('');
                $('input[name=notice-In]').val('');
                $('input[name=notice-Out]').val('');
                $('textarea[name=notice-explanation]').val('');
                $('#notice-modal').modal('show');
            });

            $('#btn-action').click(function() {
                var formData = new FormData ($('#notice-form')[0]);
                var url = $('#notice-form').attr('action');

                $.ajax({
                    type: 'ajax',
                    url: url,
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert(response['message']);

                        $('input[name=notice-date]').val('');
                        $('input[name=notice-In]').val('');
                        $('input[name=notice-Out]').val('');
                        $('input[name=notice-explanation]').val('');

                        dt.api().ajax.reload();

                        $('#notice-modal').modal('hide');
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            });

            $('#notice-nature').click(function(){

                switch ($(this).val()){
                    case 'Failure to Time-In/Time-Out':
                        console.log($(this).val());
                        $('#tardiness').show();
                        $('#notice-Out').val('');
                        break;

                    case 'Tardiness':
                        console.log($(this).val());
                        $('#tardiness').hide();
                        $('#notice-Out').val('');
                        break;
                }
            });
        });
    </script>
@endsection