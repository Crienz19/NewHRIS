@extends('layout.app')

@section('title', 'Role')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <button id="btn-create" class="btn btn-primary btn-sm pull-right m-b-5"><span class="glyphicon glyphicon-plus"></span>&nbsp; Create</button>
                    <table id="role-table" class="table table-striped table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Display Name</th>
                            <th>Description</th>
                            <th>Created_At</th>
                            <th>Action</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="role-modal" class="modal fade">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modal-title">Create New Role</h4>
                </div>
                <div class="modal-body">
                    <form id="role-form">
                        <div class="form-group">
                            <label for="role-name">Name: </label>
                            <input type="text" name="role-name" class="form-control" placeholder="Role Name">
                        </div>
                        <div class="form-group">
                            <label for="role-display-name">Display Name: </label>
                            <input type="text" name="role-display-name" class="form-control" placeholder="Display Name">
                        </div>
                        <div class="form-group">
                            <label for="role-description">Description: </label>
                            <input type="text" name="role-description" class="form-control" placeholder="Description">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-block" id="btn-action">Create</button>
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
            var dt = $('#role-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '{{ url("/roleLoad") }}',
                'dom': 'tp',
                'columns': [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'display_name', name: 'display_name' },
                    { data: 'description', name: 'description' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action' }
                ]
            });

            $('#btn-create').click(function() {
                $('#role-form').attr('action', '{{ url("/roleStore") }}');
                $('#role-form')[0].reset();
                $('#modal-title').text('Create New Role');
                $('#btn-action').text('Save');
                $('#role-modal').modal('show');
            });

            $('#role-table tbody').on('click', 'td button', function (){
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');

                switch (data) {
                    case 'edit':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/roleEdit") }}/' + dataId,
                            method: 'get',
                            dataType: 'json',
                            success: function(response) {
                                $('#role-form').attr('action', '{{ url("/roleUpdate") }}/' + dataId);
                                $('#modal-title').text('Update Role');
                                $('#btn-action').text('Update');
                                $('input[name=role-name]').val(response['name']);
                                $('input[name=role-display-name]').val(response['display_name']);
                                $('input[name=role-description]').val(response['description']);
                                dt.api().ajax.reload();
                                $('#role-modal').modal('show');
                            }
                        });
                    break;

                    case 'remove':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/roleDelete") }}/' + dataId,
                            method: 'post',
                            dataType: 'json',
                            success: function(response) {
                                dt.api().ajax.reload();
                            }
                        });
                    break;
                }
            });

            $('#btn-action').click(function() {
                var url = $('#role-form').attr('action');
                var formData = new FormData($('#role-form')[0]);

                $.ajax({
                    type: 'ajax',
                    url: url,
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        dt.api().ajax.reload();
                        $('#role-modal').modal('hide');
                    }
                });
            });
        });
    </script>
@endsection