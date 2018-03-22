@extends('layout.app')

@section('title', 'Superadmin | Leave Requests')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <table id="leave-request-table" class="table table-striped table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Branch</th>
                            <th>Type</th>
                            <th>Pay</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Time From</th>
                            <th>Time To</th>
                            <th>Reason</th>
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
                        <tr>
                            <td>Final Remarks</td>
                            <td id="f-remarks">fsfsdfdsfsdf</td>
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
            var dt = $('#leave-request-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '{{ url("/superadmin/leave") }}',
                'dom': 'tp',
                'columns': [
                    { data: 'id', name: 'id' },
                    { data: 'employee', name: 'employee' },
                    { data: 'position', name: 'position' },
                    { data: 'department', name: 'department' },
                    { data: 'branch', name: 'branch' },
                    { data: 'type', name: 'type' },
                    { data: 'pay_type', name: 'pay_type' },
                    { data: 'from', name: 'from' },
                    { data: 'to', name: 'to' },
                    { data: 'time_from', name: 'time_from' },
                    { data: 'time_to', name: 'time_to' },
                    { data: 'reason', name: 'reason' },
                    { data: 'recommending_approval', name: 'recommending_approval' },
                    { data: 'final_approval', name: 'final_approval' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action' }
                ]
            });

            $('#leave-request-table tbody').on('click', 'td button', function() {
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');

                switch (data) {
                    case 'view':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/superadmin/leave/single") }}/' + dataId,
                            method: 'get',
                            dataType: 'json',
                            success: function(response) {
                                $('#type').text(response['type']);
                                $('#pay').text(response['pay_type']);
                                $('#from').text(response['from']);
                                $('#to').text(response['to']);
                                $('#reason').text(response['reason']);
                                $('#r-remarks').text(response['recommending_approval']);
                                $('#f-remarks').text(response['final_approval']);

                                $('#view-leave').modal('show');
                            }
                        });
                        break;
                }
            });
        });
    </script>
@endsection