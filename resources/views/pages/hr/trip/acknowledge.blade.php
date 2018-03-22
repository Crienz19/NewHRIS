@extends('layout.app')

@section('title', 'HR | Acknowledged Trips')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <table id="hr-trip-acknowledged-table" class="table table-striped table-bordered">
                        <thead>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Branch</th>
                        <th>Date From</th>
                        <th>Date To</th>
                        <th>Time-In</th>
                        <th>Time-Out</th>
                        <th>Destination From</th>
                        <th>Destination To</th>
                        <th>Purpose</th>
                        <th>Status</th>
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
            var dt = $('#hr-trip-acknowledged-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '{{ url("/hr/tripRequests") }}/Acknowledged/user',
                'dom': '<"pull-right m-b-5"B><"#filter.pull-left"><t><p>',
                'buttons': [
                    {
                        extend: 'excel',
                        text: '<span class="glyphicon glyphicon-export"></span>&nbsp; Export',
                        className: 'btn btn-default btn-sm  ',
                        exportOptions: {

                        }
                    },
                    {
                        text: '<span class="glyphicon glyphicon-refresh"></span>&nbsp;Reload',
                        className: 'btn btn-primary btn-sm',
                        action: function(e, dt, node, config){
                            dt.ajax.url('{{ url("/hr/tripRequests") }}/Acknowledged/user').load();
                        }
                    }
                ],
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
                    { data: 'action', name: 'action' }
                ]
            });

            $('#hr-trip-acknowledged-table tbody').on('click', 'td button', function (){
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');

                switch (data) {
                    case 'view':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/hr/tripRequests/view") }}/' + dataId,
                            method: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                $('#date').html(response['date_from'] + ' to ' + response['date_to']);
                                $('#time').html(response['time_in'] + ' - ' + response['time_out']);
                                $('#destination').html(response['destination_from'] + ' to ' + response['destination_to']);
                                $('#purpose').html(response['purpose']);

                                $('#view-ob').modal('show');
                            }
                        });
                    break;
                }
            });
        })
    </script>
@endsection