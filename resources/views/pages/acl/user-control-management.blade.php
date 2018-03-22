@extends('layout.app')

@section('title', 'User Control Management')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <table id="user-control-table" class="table table-striped table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
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
            var dt = $('#user-control-table').dataTable({
                'processing' : true,
                'serverSide' : true,
                'ajax': '{{ url("/accessLoad") }}',
                'dom': 'tp',
                'columns': [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action' }
                ]
            });

            $('#user-control-table tbody').on('click', 'td button', function (){
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');

                switch (data) {
                    case 'assign':
                        console.log('Assign');
                        break;

                    case 'edit':
                        console.log('Edit');
                        break;

                    case 'remove':
                        console.log('Remove');
                        break;
                }
            });
        });
    </script>
@endsection