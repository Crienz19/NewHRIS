@extends('layout.app')

@section('title', 'Supervisor | OT Pending')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <table id="ot-pending-table" class="table table-striped table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Branch</th>
                            <th>Date</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Reason</th>
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
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="view-ot" class="modal fade">
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
                        </tbody>
                    </table>
                    <form id="remarks-form">
                        <div class="form-group">
                            <textarea name="remarks" id="remarks" cols="30" rows="10" class="form-control" placeholder="Remarks..."></textarea>
                            <span id="remarks-error" style="color: red;"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btn-approve" class="btn btn-success btn-sm">Approve</button>
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
            var dt = $('#ot-pending-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '{{ url("/tl/otRequests/") }}/Pending',
                'dom': 'tp',
                'columns': [
                    { data: 'id', name: 'id' },
                    { data: 'employee', name: 'employee' },
                    { data: 'position', name: 'position' },
                    { data: 'department', name: 'department' },
                    { data: 'branch', name: 'branch' },
                    { data: 'date', name: 'date' },
                    { data: 'from', name: 'from' },
                    { data: 'to', name: 'to' },
                    { data: 'reason', name: 'reason' },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action' }
                ]
            });
            var id;
            $('#ot-pending-table tbody').on('click', 'td button', function (){
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');
                id = dataId;
                switch (data) {
                    case 'view':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/tl/otRequests/view") }}/' + dataId,
                            method: 'get',
                            dataType: 'json',
                            success: function(response) {
                                $('#remarks-form')[0].reset();
                                $('#date').text(response['date']);
                                $('#from').text(response['from']);
                                $('#to').text(response['to']);
                                $('#reason').text(response['reason']);

                                $('#view-ot').modal('show');
                            }
                        });
                    break;
                }
            });

            $('#btn-approve').click(function() {
                var formData = new FormData($('#remarks-form')[0]);
                $.ajax({
                    type: 'ajax',
                    url: `{{ url("/tl/otRequests/approved") }}/${id}`,
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        dt.api().ajax.reload();
                        $('#view-ot').modal('hide');
                    }
                });
            });

            $('#btn-decline').click(function() {
                var formData = new FormData($('#remarks-form')[0]);
                $.ajax({
                    type: 'ajax',
                    url: `{{ url("/tl/otRequests/disapproved") }}/${id}`,
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        dt.api().ajax.reload();
                        $('#view-ot').modal('hide');
                    }
                });
            });
        })
    </script>
@endsection