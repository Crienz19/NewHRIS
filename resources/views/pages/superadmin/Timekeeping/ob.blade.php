@extends('layout.app')

@section('title', 'Superadmin | Trip Requests')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <table id="ob-requests-table" class="table table-striped table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Branch</th>
                            <th>Date From</th>
                            <th>Date To</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Destination From</th>
                            <th>Destination to</th>
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
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="view-ob" class="modal fade" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white;">&times;</button>
                    <h4 class="modal-title" id="modal-title">View Official Business Trip</h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Date of Trip</td>
                            <td id="date">klsjdflkjdlks</td>
                        </tr>
                        <tr>
                            <td>Time</td>
                            <td id="time">kdjlsfkjskdlfj</td>
                        </tr>
                        <tr>
                            <td>Destination</td>
                            <td id="destination">kdjlsfkjskdlfj</td>
                        </tr>
                        <tr>
                            <td>Purpose</td>
                            <td id="purpose">kdjlsfkjskdlfj</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td id="status"></td>
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
        $(document).ready(function() {
            var dt = $('#ob-requests-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '{{ url("/superadmin/trip") }}',
                'columns': [
                    { data: 'id', name: 'id' },
                    { data: 'employee', name: 'employee' },
                    { data: 'position', name: 'position' },
                    { data: 'department', name: 'department' },
                    { data: 'branch', name: 'branch' },
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

            $('#ob-requests-table tbody').on('click', 'td button', function() {
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');

                switch (data) {
                    case 'view':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/superadmin/trip/single") }}/' + dataId,
                            method: 'get',
                            dataType: 'json',
                            success: function(response) {
                                $('#date').text(`${response['date_from']} -> ${response['date_to']}`);
                                $('#time').text(`${response['time_in']} -> ${response['time_out']}`);
                                $('#destination').text(`${response['destination_from']} -> ${response['destination_to']}`);
                                $('#purpose').text(response['purpose']);
                                $('#status').text(response['status']);

                                $('#view-ob').modal('show');
                            }
                        });
                        break;
                }
            });
        })
    </script>
@endsection