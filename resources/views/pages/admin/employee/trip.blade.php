@extends('layout.app')

@section('title', 'Admin | Employee Trip')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <table id="emp-trip-table" class="table table-striped table-bordered">
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
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var dt = $('#emp-trip-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '{{ url("/admin/tripRequests") }}/user/Pending',
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
                            dt.ajax.url('{{ url("admin/tripRequests") }}/user/Pending').load();
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

            $('#emp-trip-table tbody').on('click', 'td button', function (){
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');

                switch (data) {
                    case 'view':
                        console.log(dataId);
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
                dt.api().ajax.url('{{ url("admin/tripRequests") }}/user/'+ status +'').load();
            });
        });
    </script>
@endsection