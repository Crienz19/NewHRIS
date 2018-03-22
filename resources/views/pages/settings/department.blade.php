@extends('layout.app')

@section('title', 'Department')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <button id="btn-create" class="btn btn-primary btn-sm pull-right" style="margin-bottom: 5px;"><span class="glyphicon glyphicon-plus"></span>&nbsp;Create</button>
                    <table id="department-table" class="table table-striped table-bordered">
                        <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Value</th>
                        <th>Supervisor</th>
                        <th>Created At</th>
                        <th>Action</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="department-modal" class="modal fade">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modal-title">Add Department</h4>
                </div>
                <div class="modal-body">
                    <form id="department-form">
                        <input type="hidden" name="dept-id">
                        <div class="form-group">
                            <label for="department-name">Department: </label>
                            <input type="text" name="department-name" class="form-control" placeholder="Department Name">
                        </div>
                        <div class="form-group">
                            <label for="department-value">Value: </label>
                            <input type="text" name="department-value" class="form-control" placeholder="Department Value">
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

    <!-- modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="supervisor-modal" class="modal fade">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h4 class="modal-title" id="modal-title">Assign Supervisor</h4>
                </div>
                <div class="modal-body">
                    <form id="supervisor-form">
                        <input type="hidden" name="dept-id">
                        <div class="form-group">
                            <label class="control-label" for="sup-name">Supervisor:</label>
                            <select class="form-control" name="sup-name" id="sup-name"></select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-block" id="btn-assign">Assign</button>
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
            loadTL();

            var dt = $('#department-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax' : '{{ url("/departmentLoad") }}',
                'dom': 'tp',
                'columns': [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'value', name: 'value' },
                    { data: 'supervisor', name: 'supervisor' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action' }
                ]
            });

            $('#department-table tbody').on('click', 'td button', function (){
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');

                switch (data) {
                    case 'assign':
                        $('input[name=dept-id]').val(dataId);
                        $('#supervisor-modal').modal('show');
                        break;

                    case 'edit':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("departmentEdit") }}/'+ dataId,
                            method: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                $('#modal-title').text('Update Department');
                                $('#btn-action').text('Update');
                                $('#department-form').attr('action', '{{ url("departmentUpdate") }}/'+dataId);
                                $('input[name=department-name]').val(response['name']);
                                $('input[name=department-value]').val(response['value']);
                                $('#department-modal').modal('show');
                            }
                        });
                        break;

                    case 'remove':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("departmentDelete") }}/'+dataId,
                            method: 'post',
                            dataType: 'json',
                            success: function(response){
                                dt.api().ajax.reload();
                                $('#department-modal').modal('hide');
                            }
                        });
                        break;
                }
            });

            $('#btn-create').click(function() {
                $('#modal-title').text('New Department');
                $('#btn-action').text('Save');
                $('#department-modal').modal('show');
                $('#department-form').attr('action', '{{ url("/departmentStore") }}');
                $('#department-form')[0].reset();
            });

            $('#btn-action').click(function() {
                var formData = new FormData($('#department-form')[0]);
                var url = $('#department-form').attr('action');
                $.ajax({
                    type: 'ajax',
                    url: url,
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        dt.api().ajax.reload();
                        $('#department-modal').modal('hide');
                        console.log(response);
                    }
                });
            });

            $('#btn-assign').click(function() {
                var formData = new FormData($('#supervisor-form')[0]);

                $.ajax({
                    type: 'ajax',
                    url: '{{ url("/tl/assign") }}',
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        dt.api().ajax.reload();
                        $('#supervisor-modal').modal('hide');
                    }
                });
            });

            function loadTL() {
                $.ajax({
                    type: 'ajax',
                    url: '{{ url("/helper/sup") }}',
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        var html = '<option value="">Select</option>';

                        $.each(response, function(i, sup) {
                            html += '<option value="'+sup['id']+'">'+sup['employee']+'</option>';
                        });

                        $('#sup-name').html(html);
                    }
                });
            }
        })
    </script>
@endsection