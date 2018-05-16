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
            var dt = $('#ot-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '/hr/otRequests/Pending/user',
                'dom': 'tp',
                'columns': [
                    {  }
                ]
            })
        });
    </script>
@endsection