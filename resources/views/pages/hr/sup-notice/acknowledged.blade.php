@extends('layout.app')

@section('title', 'Notice Slip')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <table id="notice-table" class="table table-striped table-bordered">
                        <thead>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Branch</th>
                        <th>Nature of Action</th>
                        <th>Date</th>
                        <th>Time-In</th>
                        <th>Time-Out</th>
                        <th>Explanation</th>
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
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Nature of Action</td>
                            <td id="nature">##########</td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td id="date">##########</td>
                        </tr>
                        <tr>
                            <td>Time-In</td>
                            <td id="time-in">###########</td>
                        </tr>
                        <tr>
                            <td>Time-Out</td>
                            <td id="time-out">##############</td>
                        </tr>
                        <tr>
                            <td>Explanation</td>
                            <td id="explanation">#############</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td id="status">################</td>
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
            var dt = $('#notice-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '{{ url("/hr/noticeRequests") }}/Acknowledged/supervisor',
                'dom': 'tp',
                'columns': [
                    { data: 'employee', name: 'employee' },
                    { data: 'department', name: 'department' },
                    { data: 'position', name: 'position' },
                    { data: 'branch', name: 'branch' },
                    { data: 'nature', name: 'nature' },
                    { data: 'date', name: 'date' },
                    { data: 'time_in', name: 'time_in' },
                    { data: 'time_out', name: 'time_out' },
                    { data: 'explanation', name: 'explanation' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action' },
                ]
            });
            var id;
            $('#notice-table tbody').on('click', 'td button', function (){
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');
                id = dataId;

                switch (data) {
                    case 'view':
                        $.ajax({
                            type: 'ajax',
                            url: `{{ url("/hr/noticeRequest/view/") }}/${dataId}`,
                            method: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                $('#nature').text(response['nature']);
                                $('#date').text(response['date']);
                                $('#time-in').text(response['time_in']);
                                $('#time-out').text(response['time_out']);
                                $('#explanation').text(response['explanation']);
                                $('#status').text(response['status']);
                                $('#notice-modal').modal('show');
                            }
                        });
                        break;
                }
            });
        });
    </script>
@endsection