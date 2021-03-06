@extends('layout.app')

@section('title', 'HR | OT Disapproved')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <table id="hr-ot-disapproved-table" class="table table-striped table-bordered">
                        <thead>
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
            var dt = $('#hr-ot-disapproved-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '{{ url("/hr/otRequests") }}/Disapproved/supervisor',
                "iDisplayLength": 500,
                'dom': '<"pull-right m-b-5"B><"#filter.pull-left"><t><p>',
                'buttons': [
                    {
                        extend: 'excel',
                        text: '<span class="glyphicon glyphicon-export"></span>&nbsp; Export',
                        className: 'btn btn-default btn-sm',
                        exportOptions: {

                        }
                    },
                    {
                        text: '<span class="glyphicon glyphicon-refresh"></span>&nbsp;Reload',
                        className: 'btn btn-primary btn-sm',
                        action: function(e, dt, node, config){
                            dt.ajax.url('{{ url("/hr/otRequests") }}/Disapproved').load();
                        }
                    }
                ],
                'columns': [
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

            $('#filter').html('<div class="form-inline m-b-5">\n' +
                '                        <div class="form-group">\n' +
                '                            <label for="from-filter">From: </label>\n' +
                '                            <input type="date" class="form-control input-sm" id="from-filter" name="from-filter">\n' +
                '                        </div>\n' +
                '                        &nbsp;\n' +
                '                        <div class="form-group">\n' +
                '                            <label for="to-filter">To: </label>\n' +
                '                            <input type="date" class="form-control input-sm" id="to-filter" name="to-filter">\n' +
                '                        </div>\n' +
                '                        <div class="form-group">\n' +
                '                            <label for="branch">Branch: </label>\n' +
                '                            <select class="form-control input-sm" id="branch" name="branch">' +
                '                            </select>\n' +
                '                        </div>\n' +
                '                        <div class="form-group">\n' +
                '                            <button class="btn btn-primary btn-sm col-xs-12" id="btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>\n' +
                '                        </div>\n' +
                '                    </div>' +
                '');

            loadBranch();

            function loadBranch()
            {
                $.ajax({
                    type: 'ajax',
                    url: '{{ url("/helper/branch") }}',
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        var html = '<option value="">Select Branch</option>';
                        $.each(response, function(i, branch) {
                            html += '' +
                                '<option value="'+ branch['id'] +'">'+ branch['name'] +'</option>';
                        });

                        $('#branch').html(html);
                    }
                });
            }

            $('#btn-filter').click(function() {
                var start = $('input[name=from-filter]').val();
                var end = $('input[name=to-filter]').val();
                var status = 'Disapproved';
                var branch = $('select[name=branch]').val();
                dt.api().ajax.url('{{ url("/filter/otRequest") }}/user/' + start + '/' + end + '/' + status + '/' + branch + '').load();
            });

            var id;
            $('#hr-ot-disapproved-table tbody').on('click', 'td button', function (){
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');

                id = dataId;
                switch (data) {
                    case 'view':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/hr/otRequest/view/") }}/' + dataId,
                            method: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                $('#date').text(response['date']);
                                $('#from').text(response['from']);
                                $('#to').text(response['to']);
                                $('#reason').text(response['reason']);
                                $('#remarks').text(response['remarks']);
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
                    url: '{{ url("/hr/otRequest/approved") }}/' + id,
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