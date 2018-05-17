@extends('layout.app')

@section('title', 'Employee Overtime')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <table id="ot-table" class="table table-striped table-bordered">
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
            var dt = $('#ot-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '/hr/otRequests/Pending/user',
                'dom': '<"pull-right m-b-5"B><"#filter.pull-left"><t><p>',
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
                    { data: 'created_at', name: 'created_at' }
                ]
            })
        });
    </script>
@endsection