@extends('layout.app')

@section('title', 'HR | Leave Approved')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <table id="hr-leave-approved-table" class="table table-striped table-bordered">
                        <thead>
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
                <div class="modal-footer">
                    <button id="btn-decline" class="btn btn-danger btn-sm">Decline</button>
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
            var dt = $('#hr-leave-approved-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '{{ url("/hr/leaveRequests") }}/Approved/user',
                "iDisplayLength": 500,
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
                            dt.ajax.url('{{ url("/hr/leaveRequests") }}/Approved/supervisor').load();
                        }
                    }
                ],
                'columns': [
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
                    { data: 'final_approval', name: 'final_approval'},
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action'}
                ]
            });
            var id;
            $('#hr-leave-approved-table tbody').on('click', 'td button', function (){
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');
                id = dataId;

                switch (data) {
                    case 'view':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/hr/leaveRequest/view") }}/' + dataId,
                            method: 'get',
                            dataType: 'json',
                            success: function(response) {
                                $('#type').text(response['type']);
                                $('#pay').text(response['pay_type']);
                                $('#reason').text(response['reason']);
                                $('#from').text(response['from']);
                                $('#to').text(response['to']);
                                $('#r-remarks').text(response['remarks']);
                                $('#view-leave').modal('show');
                            }
                        });
                    break;
                }
            });

            $('#btn-decline').click(function() {
                var formData = new FormData($('#remarks-form')[0]);

                $.ajax({
                    type: 'ajax',
                    url: '{{ url("/hr/leaveRequests/disapproved") }}/' + id,
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        dt.api().ajax.reload();
                        $('#view-leave').modal('hide');
                    }
                });
            });
        });
    </script>
@endsection