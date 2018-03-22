@extends('layout.app')

@section('title', 'Branch')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <button id="btn-create" class="btn btn-primary btn-sm pull-right" style="margin-bottom: 5px;"><span class="glyphicon glyphicon-plus"></span>&nbsp; Create</button>
                    <table class="table table-striped table-bordered" id="branch-table">
                        <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Action</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="branch-modal" class="modal fade">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modal-title">Add Department</h4>
                </div>
                <div class="modal-body">
                    <form id="branch-form">
                        <input type="hidden" name="dept-id">
                        <div class="form-group">
                            <label for="branch-name">Branch: </label>
                            <input type="text" name="branch-name" class="form-control" placeholder="Branch Name">
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
        $(document).ready(function () {
            var dt = $('#branch-table').dataTable({
                'processing' : true,
                'serverSide' : true,
                'ajax': '{{ url("/branchLoad") }}',
                'dom': 'tp',
                'columns': [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action' }
                ]
            });

            $('#branch-table tbody').on('click', 'td button', function() {
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');

                switch(data) {
                    case 'edit':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/branchEdit") }}/' + dataId,
                            method: 'get',
                            dataType: 'json',
                            success: function(response) {
                                $('#modal-title').text('Update Branch');
                                $('#btn-action').text('Update');
                                $('#branch-form').attr('action', '{{ url("/branchUpdate") }}/' + dataId);
                                $('input[name=branch-name]').val(response['name']);
                                $('#branch-modal').modal('show');
                            }
                        });
                        break;

                    case 'remove':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/branchDelete") }}/' + dataId,
                            method: 'post',
                            dataType: 'json',
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                dt.api().ajax.reload();
                                console.log(response);
                            }
                        });
                        break;
                }
            });

            $('#btn-create').click(function() {
                $('#modal-title').text('New Branch');
                $('#btn-action').text('Save');
                $('#branch-form').attr('action', '{{ url("/branchStore") }}');
                $('#branch-form')[0].reset();
                $('#branch-modal').modal('show');
            });

            $('#btn-action').click(function() {
                var formData = new FormData($('#branch-form')[0]);
                var url = $('#branch-form').attr('action');

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
                        $('#branch-modal').modal('hide');
                        console.log(response);
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            });
        });
    </script>
@endsection