@extends('layout.app')

@section('title', 'Admin | Employee Leave')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <table id="emp-leave-table" class="table table-striped table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Position</th>
                            <th>Depatment</th>
                            <th>Branch</th>
                            <th>Type of Leave</th>
                            <th>Type of Pay</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Reason</th>
                            <th>Time From</th>
                            <th>Time To</th>
                            <th>TL Approval</th>
                            <th>HR Approval</th>
                            <th>Action</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="view-leave" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Leave View</h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Leave Type</td>
                            <td id="type">klsjdflkjdlks</td>
                        </tr>
                        <tr>
                            <td>Leave Pay</td>
                            <td id="pay">klsjdflkjdlks</td>
                        </tr>
                        <tr>
                            <td>Leave From</td>
                            <td id="from">kdjlsfkjskdlfj</td>
                        </tr>
                        <tr>
                            <td>Leave To</td>
                            <td id="to">kdjlsfkjskdlfj</td>
                        </tr>
                        <tr>
                            <td>Reason</td>
                            <td id="reason">kdjlsfkjskdlfj</td>
                        </tr>
                        <tr>
                            <td>Recommending Remarks</td>
                            <td id="r-remarks">fsfsdfdsfsdf</td>
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
            var dt = $('#emp-leave-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '{{ url("admin/leaveRequests") }}/user/Pending',
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
                            dt.ajax.url('{{ url("admin/leaveRequests") }}/Pending/user').load();
                        }
                    }
                ],
                'columns': [
                    { data: 'id', name: 'id'},
                    { data: 'employee', name: 'employee'},
                    { data: 'position', name: 'position'},
                    { data: 'department', name: 'department'},
                    { data: 'branch', name: 'branch'},
                    { data: 'type', name: 'type'},
                    { data: 'pay_type', name: 'pay_type'},
                    { data: 'from', name: 'from'},
                    { data: 'to', name: 'to'},
                    { data: 'reason', name: 'reason'},
                    { data: 'time_from', name: 'time_from'},
                    { data: 'time_to', name: 'time_to'},
                    { data: 'recommending_approval', name: 'recommending_approval' },
                    { data: 'final_approval', name: 'final_approval'},
                    { data: 'action', name: 'action'}
                ]
            });

            $('#filter').html('<div class="form-inline m-b-5">\n' +
                '                        <div class="form-group">\n' +
                '                            <label for="status">Status: </label>\n' +
                '                            <select class="form-control input-sm" name="status">' +
                '                               <option value="Pending">Pending</option>' +
                '                               <option value="Approved">Approved</option>' +
                '                               <option value="Disapproved">Disapproved</option>' +
                '                            </select>\n' +
                '                        </div>\n' +
                '                        <div class="form-group">\n' +
                '                            <button class="btn btn-primary btn-sm col-xs-12" id="btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>\n' +
                '                        </div>\n' +
                '                    </div>' +
                '');

            $('#emp-leave-table tbody').on('click', 'td button', function (){
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');

                switch (data) {
                    case 'view':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/admin/leaveRequest/view") }}/' + dataId,
                            method: 'get',
                            dataType: 'json',
                            success: function(response) {
                                $('#type').html(response['type']);
                                $('#pay').html(response['pay_type']);
                                $('#from').html(response['from']);
                                $('#to').html(response['to']);
                                $('#reason').html(response['reason']);
                                $('#r-remarks').html(response['final_approval']);

                                $('#view-leave').modal('show');
                            }
                        });
                        break;
                }
            });

            $('#btn-filter').click(function() {
                var status = $('select[name=status]').val();
                dt.api().ajax.url('{{ url("admin/leaveRequests") }}/user/'+ status +'').load();
            });
        });
    </script>
@endsection