@extends('layout.app')

@section('title', 'Employee Profile')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-body">
                    <table id="employee-table" class="table table-striped table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Fullname</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Email</th>
                            <th>Branch Assigned</th>
                            <th>Action</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="employee-modal" class="modal fade">
        <form action="" id="forgot-form">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Employee Details</h4>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#profile" aria-controls="home" role="tab" data-toggle="tab">Profile</a></li>
                            <li role="presentation"><a href="#discipline" aria-controls="messages" role="tab" data-toggle="tab">Disciplinary Action Records</a></li>
                            <li role="presentation"><a href="#training" aria-controls="settings" role="tab" data-toggle="tab">Training and Development</a></li>
                            <li role="presentation"><a href="#benefits" aria-controls="settings" role="tab" data-toggle="tab">Benefits</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="profile">
                                <div class="panel panel-default" style="margin-top: 5px;">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <a href="#" class="thumbnail">
                                                    <img src="https://placeimg.com/171/180/any">
                                                </a>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="col-xs-6"><small>Employee ID:</small></label><label class="col-xs-6"><small id="emp-id">20172510</small></label>
                                                <label class="col-xs-6"><small>Fullname:</small></label><label class="col-xs-6"><small id="full-name">Renz D. Mergenio</small></label>
                                                <label class="col-xs-6"><small>Birthdate:</small></label><label class="col-xs-6"><small id="birthdate">January 28, 1996</small></label>
                                                <label class="col-xs-6"><small>Position:</small></label><label class="col-xs-6"><small id="position">IT Specialist</small></label>
                                                <label class="col-xs-6"><small>Department:</small></label><label class="col-xs-6"><small id="department">IT Department</small></label>
                                                <label class="col-xs-6"><small>Branch:</small></label><label class="col-xs-6"><small id="branch">Manila - Main Office</small></label>
                                                <label class="col-xs-6"><small>Civil Status:</small></label><label class="col-xs-6"><small id="c-status">Single</small></label>
                                                <label class="col-xs-6"><small>Contact #1:</small></label><label class="col-xs-6"><small id="contact1">09123456789</small></label>
                                                <label class="col-xs-6"><small>Contact #2:</small></label><label class="col-xs-6"><small id="contact2">09123456789</small></label>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="col-xs-6"><small>Date Hired:</small></label><label class="col-xs-6"><small id="date-hired">2017-10-25</small></label>
                                                <label class="col-xs-6"><small>Present Address:</small></label><label class="col-xs-6"><small id="pr-address">Bagong Silang, Caloocan City</small></label>
                                                <label class="col-xs-6"><small>Permanent Address:</small></label><label class="col-xs-6"><small id="pe-address">Bagong Silang, Caloocan City</small></label>
                                                <label class="col-xs-6"><small>Skype ID:</small></label><label class="col-xs-6"><small id="skype">live:rmergenio_1</small></label>
                                                <label class="col-xs-6"><small>Company E-mail:</small></label><label class="col-xs-6"><small id="email">rmergenio@ziptravel.com.ph</small></label>
                                                <label class="col-xs-6"><small>TIN:</small></label><label class="col-xs-6"><small id="tin">das</small></label>
                                                <label class="col-xs-6"><small>SSS:</small></label><label class="col-xs-6"><small id="sss">das</small></label>
                                                <label class="col-xs-6"><small>HDMF:</small></label><label class="col-xs-6"><small id="hdmf">sad</small></label>
                                                <label class="col-xs-6"><small>PHIC:</small></label><label class="col-xs-6"><small id="phic">asd</small></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="col-xs-12">
                                            <label>Vacation Leave: </label>
                                            <div class="progress">
                                                <div id="VL" class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%; background-color: #051a40;" >
                                                    <span id="VL-text"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <label>Sick Leave: </label>
                                            <div class="progress">
                                                <div id="SL" class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%; background-color: #092b69;">
                                                    <span id="SL-text"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <label>Personal Time-Off: </label>
                                            <div class="progress">
                                                <div id="PTO" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 75%; background-color: #051a40">
                                                    <span id="PTO-text"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <label>Overtime: </label>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-danger progress-bar-info progress-bar-animated" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%; background-color:  #8c6000;">
                                                    <span id="OT-text"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <label>Official Business Trip:</label>
                                            <div class="progress">
                                                <div id="OB" class="progress-bar progress-bar-info progress-bar-animated" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%; background-color: #8c6000;">
                                                    <span id="OB-text"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="discipline">
                                <table id="da-table" class="table table-striped table-bordered" style="margin-top: 5px;">
                                    <thead>
                                        <th>#</th>
                                        <th>#</th>
                                        <th>#</th>
                                        <th>#</th>
                                        <th>#</th>
                                    </thead>
                                </table>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="training">
                                <table id="training-table" class="table table-striped table-bordered" style="margin-top: 5px;">
                                    <thead>
                                    <th>#</th>
                                    <th>#</th>
                                    <th>#</th>
                                    <th>#</th>
                                    <th>#</th>
                                    </thead>
                                </table>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="benefits">
                                    fsdfasdfsadf
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- modal -->

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="access-modal" class="modal fade">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modal-title">Create New Role</h4>
                </div>
                <div class="modal-body">
                    <form id="access-form">
                        <div class="form-group">
                            <label for="role">Role: </label>
                            <select name="role" id="role" class="form-control"></select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-block" id="btn-action">Assign Role</button>
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
            loadRole();
            function employeeDetails(id){
                $.ajax({
                    type: 'ajax',
                    url: '{{ url("/employeeShow") }}/' + id,
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        $('#emp-id').html(response['employee_no']);
                        $('#full-name').html(response['full_name']);
                        $('#birthdate').html(response['birthdate']);
                        $('#position').html(response['position']);
                        $('#department').html(response['department']);
                        $('#branch').html(response['branch']);
                        $('#c-status').html(response['civil_status']);
                        $('#contact1').html(response['contact_1']);
                        $('#contact2').html(response['contact_2']);
                        $('#date-hired').html(response['date_hired']);
                        $('#pr-address').html(response['present_address']);
                        $('#pe-address').html(response['permanent_address']);
                        $('#skype').html(response['skype']);
                        $('#email').html(response['email']);
                        $('#tin').html(response['tin']);
                        $('#sss').html(response['sss']);
                        $('#hdmf').html(response['hdmf']);
                        $('#phic').html(response['phic']);

                        var vl = (response['VL'] / response['total_VL']) * 100;
                        var sl = (response['SL'] / response['total_SL']) * 100;
                        var pto = (response['PTO'] / response['total_PTO']) * 100;
                        $('#VL').width(vl + '%');
                        $('#SL').width(sl + '%');
                        $('#PTO').width(pto + '%');

                        $('#VL-text').html(response['VL'] + '/' + response['total_VL']);
                        $('#SL-text').html(response['SL'] + '/' + response['total_SL']);
                        $('#PTO-text').html(response['PTO'] + '/' + response['total_PTO']);
                        $('#OT-text').html(response['OT']);
                        $('#OB-text').html(response['OB']);
                    }
                });
            }

            function loadRole() {
                $.ajax({
                    type: 'ajax',
                    url: '{{ url("/helper/role") }}',
                    method: 'get',
                    dataType: 'json',
                    success: function(response){
                        var html = '<option value="">Select Role</option>';
                        $.each(response, function(i, role) {
                            html +='<option value="'+ role['id'] +'">'+ role['display_name'] +'</option>'
                        });
                        $('select[name=role]').html(html);
                    }
                });
            }

            var dt = $('#employee-table').dataTable({
                'processing': true,
                'serverSide': true,
                'ajax': '{{ url("/employeeLoad") }}',
                'dom': 'tp',
                'columns': [
                    { data: 'id', name: 'id' },
                    { data: 'full_name', name: 'full_name' },
                    { data: 'position', name: 'position' },
                    { data: 'department', name: 'department' },
                    { data: 'email', name: 'email' },
                    { data: 'branch', name: 'branch' },
                    { data: 'action', name: 'action' }
                ]
            });

            var daDT = $('#da-table').dataTable({
                'dom': 'tp'
            });

            var tdDT = $('#training-table').dataTable({
                'dom': 'tp'
            });

            var id;

            $('#employee-table tbody').on('click', 'td button', function (){
                var data = $(this).attr('data');
                var dataId = $(this).attr('data-id');
                id = dataId;

                switch (data) {
                    case 'view':
                        $('#employee-modal').modal('show');
                        employeeDetails(dataId);
                        break;

                    case 'assign':
                        $('#access-modal').modal('show');
                        break;

                    case 'reset':
                        $.ajax({
                            type: 'ajax',
                            url: '{{ url("/reset/password") }}/' + dataId,
                            method: 'post',
                            dataType: 'json',
                            success: function(response) {
                                alert(response)
                            }
                        });
                        break;

                    case 'remove':

                        break;
                }
            });

            $('#btn-action').click(function() {
                var formData = new FormData($('#access-form')[0]);

                $.ajax({
                    type: 'ajax',
                    url: '{{ url("/accessAssign") }}/' + id,
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#access-modal').modal('hide');
                    }
                });
            });
        });
    </script>
@endsection