@extends('layout.app')

@section('title', 'Admin | Employee Trip')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <table id="supervisor-trip-table" class="table table-striped table-bordered">
                        <thead>
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
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="view-ob" class="modal fade">
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
                            <td>Destination</td>
                            <td id="destination">kdjlsfkjskdlfj</td>
                        </tr>
                        <tr>
                            <td>Time In/Time Out</td>
                            <td id="time">kdjlsfkjskdlfj</td>
                        </tr>
                        <tr>
                            <td>Purpose</td>
                            <td id="purpose">kdjlsfkjskdlfj</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td id="status">fsdfsfdsfsd</td>
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
            var dt = $('#supervisor-trip-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '{{ url("/admin/tripRequests") }}/supervisor/Pending',
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
                            dt.ajax.url('{{ url("admin/tripRequests") }}/supervisor/Pending').load();
                        }
                    }
                ],
                'columns': [
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

            $('#supervisor-trip-table tbody').on('click', 'td button', function (){
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');

                switch (data) {
                    case 'view':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/admin/tripRequest/view") }}/' + dataId,
                            method: 'get',
                            dataType: 'json',
                            success: function(response){
                                console.log(response);
                                $('#view-ob').modal('show');
                                $('#date').text(response['date_from'] + ' => ' + response['date_to']);
                                $('#destination').text(response['destination_from'] + ' => ' + response['destination_to']);
                                $('#time').text(response['time_in'] + ' => ' + response['time_out']);
                                $('#purpose').text(response['purpose']);
                                $('#status').text(response['status']);
                            }
                        });
                        break;
                }
            });

            $('#filter').html('<div class="form-inline m-b-5">\n' +
                '                        <div class="form-group">\n' +
                '                            <label for="status">Status: </label>\n' +
                '                            <select class="form-control input-sm" name="status">' +
                '                               <option value="Pending">Pending</option>' +
                '                               <option value="Approved">Acknowledged</option>' +
                '                            </select>\n' +
                '                        </div>\n' +
                '                        <div class="form-group">\n' +
                '                            <button class="btn btn-primary btn-sm col-xs-12" id="btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>\n' +
                '                        </div>\n' +
                '                    </div>' +
                '');

            $('#btn-filter').click(function() {
                var status = $('select[name=status]').val();
                dt.api().ajax.url('{{ url("admin/tripRequests") }}/supervisor/'+ status +'').load();
            });
        });
    </script>
@endsection