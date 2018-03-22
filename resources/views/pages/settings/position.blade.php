@extends('layout.app')

@section('title', 'Position')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <button id="btn-create" class="btn btn-primary btn-sm pull-right" style="margin-bottom: 5px;"><span class="glyphicon glyphicon-plus"></span>&nbsp; Create</button>
                    <table id="position-table" class="table table-striped table-bordered">
                        <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Department</th>
                        <th>Created At</th>
                        <th>Action</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="position-modal" class="modal fade">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modal-title">Add Department</h4>
                </div>
                <div class="modal-body">
                    <form id="position-form">
                        <input type="hidden" name="dept-id">
                        <div class="form-group">
                            <label for="position-name">Position: </label>
                            <input type="text" name="position-name" class="form-control" placeholder="Department Name">
                        </div>
                        <div class="form-group">
                            <label for="position-description">Description: </label>
                            <input type="text" name="position-description" class="form-control" placeholder="Department Value">
                        </div>
                        <div class="form-group">
                            <label for="position-dept">Department: </label>
                            <select class="form-control" name="position-dept" id="position-dept">

                            </select>
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
            function loadDepartment(){
                $.ajax({
                    type: 'ajax',
                    url: '{{ url("/helper/department") }}',
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        var html = '<option value="">Select Department</option>';
                        $.each(response, function(i, value){
                            html += '<option value="'+value['id']+'">'+value['name']+'</option>';
                        });
                        $('#position-dept').html(html);
                    }
                });
            }

            var dt = $('#position-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '{{ url("/positionLoad") }}',
                'dom': 'tp',
                'columns': [
                    { data: 'id', name: 'positions.id' },
                    { data: 'name', name: 'positions.name' },
                    { data: 'description', name: 'positions.description' },
                    { data: 'department', name: 'departments.name' },
                    { data: 'created_at', name: 'positions.created_at' },
                    { data: 'action', name: 'action' }
                ]
            });

            $('#position-table tbody').on('click', 'td button', function (){
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');

                switch (data) {
                    case 'edit':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/positionEdit") }}/' + dataId,
                            method: 'get',
                            dataType: 'json',
                            success: function(response) {
                                $('#position-form').attr('action', '{{ url("/positionUpdate") }}/' + dataId);
                                $('#modal-title').text('Update Position');
                                $('#btn-action').text('Update');

                                $('input[name=position-name]').val(response['name']);
                                $('input[name=position-description]').val(response['description']);
                                loadDepartment();
                                $('#position-modal').modal('show');
                            }
                        });
                        break;

                    case 'remove':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/positionDelete") }}/' + dataId,
                            method: 'post',
                            dataType: 'json',
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                dt.api().ajax.reload();
                                console.log(response);
                            },
                            error: function(response) {
                                console.log(response);
                            }
                        });
                        break;
                }
            });

            $('#btn-create').click(function() {
                loadDepartment();
                $('#position-form').attr('action', '{{ url("/positionStore") }}');
                $('#position-form')[0].reset();
                $('#modal-title').text('Add Position');
                $('#btn-action').text('Save');
                $('#position-modal').modal('show');
            });

            $('#btn-action').click(function() {
                var formData = new FormData($('#position-form')[0]);
                var url = $('#position-form').attr('action');

                $.ajax({
                    type: 'ajax',
                    url: url,
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        dt.api().ajax.reload();
                        $('#position-modal').modal('hide');
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            });
        })
    </script>
@endsection