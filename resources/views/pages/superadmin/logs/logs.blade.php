@extends('layout.app')

@section('title', 'Superadmin | Logs')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <table id="log-table" class="table table-striped table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Branch</th>
                            <th>Activity</th>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            var dt = $('#log-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '{{ url("/superadmin/load/logs") }}',
                'columns': [
                    { data: 'id', name: 'id' },
                    { data: 'employee', name: 'employee' },
                    { data: 'position', name: 'position' },
                    { data: 'department', name: 'department' },
                    { data: 'branch', name: 'branch' },
                    { data: 'activity', name: 'activity' },
                    { data: 'action', name: 'action' },
                ]
            });

            $('#log-table tbody').on('click', 'td button', function() {
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');

                switch (data) {
                    case 'remove':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/superadmin/delete/log") }}/' + dataId,
                            method: 'post',
                            dataType: 'json',
                            success: function(response) {
                                alert(response.message);
                                dt.api().ajax.reload();
                            }
                        });
                        break;
                }
            });
        });
    </script>
@endsection