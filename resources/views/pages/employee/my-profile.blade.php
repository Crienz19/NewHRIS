@extends('layout.app')

@section('title', 'My Profile')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <center><h5>My Profile</h5></center>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="col-xs-6 col-xs-offset-3">
                                <a href="#" class="thumbnail">
                                    <img id="photo" src="https://placeimg.com/250/250/any">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-xs-6">Employee ID:</label><label class="col-xs-6" id="emp-id">20171025</label>
                            <label class="col-xs-6">Full Name:</label><label class="col-xs-6" id="fullname">Renz D. Mergenio</label>
                            <label class="col-xs-6">Birthdate:</label><label class="col-xs-6" id="birthdate">January 28, 1996</label>
                            <label class="col-xs-6">Department:</label><label class="col-xs-6" id="department">IT Department</label>
                            <label class="col-xs-6">Position:</label><label class="col-xs-6" id="position">IT Specialist</label>
                            <label class="col-xs-6">Branch:</label><label class="col-xs-6" id="branch">Manila</label>
                            <label class="col-xs-6">Status:</label><label class="col-xs-6" id="c-status">Single</label>
                            <label class="col-xs-6">Contact #1:</label><label class="col-xs-6" id="contact-1">09123456789</label>
                            <label class="col-xs-6">Contact #2:</label><label class="col-xs-6" id="contact-2">09123456789</label>
                        </div>
                        <div class="col-md-4">
                            <label class="col-xs-6">Date Hired:</label><label class="col-xs-6" id="date-hired">20171025</label>
                            <label class="col-xs-6">Present Address:</label><label class="col-xs-6" id="pre-address">Renz D. Mergenio</label>
                            <label class="col-xs-6">Permanent Address:</label><label class="col-xs-6" id="per-address">January 28, 1996</label>
                            <label class="col-xs-6">Skype ID:</label><label class="col-xs-6" id="skype">IT Department</label>
                            <label class="col-xs-6">E-mail:</label><label class="col-xs-6" id="email">IT Specialist</label>
                            <label class="col-xs-6">TIN:</label><label class="col-xs-6" id="tin">Manila</label>
                            <label class="col-xs-6">SSS:</label><label class="col-xs-6" id="sss">Single</label>
                            <label class="col-xs-6">HDMF:</label><label class="col-xs-6" id="hdmf">09123456789</label>
                            <label class="col-xs-6">PHIC:</label><label class="col-xs-6" id="phic">09123456789</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <center><h5>Filing Credits</h5></center>
                </div>
                <div class="panel-body">
                    <div class="col-xs-12">
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
        </div>
    </div>

    <!-- modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="edit-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="edit-modal-title">Update </h4>
                </div>
                <div class="modal-body">
                    <form id="edit-form">
                        <input type="text" class="form-control" name="emp-id-field" id="emp-id-field" placeholder="Enter Employee ID">
                        <div id="full-name">
                            <input type="text" class="form-control" name="firstname-field" id="firstname-field" placeholder="Enter First Name"><br>
                            <input type="text" class="form-control" name="middlename-field" id="middlename-field" placeholder="Enter Middle Name"><br>
                            <input type="text" class="form-control" name="lastname-field" id="lastname-field" placeholder="Enter Last Name">
                        </div>
                        <input type="date" class="form-control" id="birthdate-field" name="birthdate-field">
                        <select name="department-field" id="department-field" class="form-control"></select><br>
                        <select name="position-field" id="position-field" class="form-control"></select>
                        <select name="branch-field" id="branch-field" class="form-control">
                            <option value="" selected>Select Branch</option>
                            <option value="MANILA">MANILA</option>
                            <option value="CEBU">CEBU</option>
                            <option value="DAVAO">DAVAO</option>
                            <option value="PAMPANGA">PAMPANGA</option>
                        </select>
                        <select name="status-field" id="status-field" class="form-control">
                            <option value="" selected>SELECT STATUS</option>
                            <option value="SINGLE">SINGLE</option>
                            <option value="MARRIED">MARRIED</option>
                            <option value="DIVORCED">DIVORCED</option>
                            <option value="WIDOWED">WIDOWED</option>
                        </select>
                        <input type="date" name="date-hired-field" class="form-control" id="date-hired-field">
                        <input type="text" name="contact-field-1" class="form-control" id="contact-field-1" placeholder="Contact #">
                        <input type="text" name="contact-field-2" class="form-control" id="contact-field-2" placeholder="Contact #">
                        <input type="email" name="email-field" class="form-control" id="email-field" placeholder="E-mail">
                        <input type="text" name="skype-field" class="form-control" id="skype-field" placeholder="Skypde ID">
                        <input type="text" name="perm-address-field" class="form-control" id="perm-address-field" placeholder="Permanent Address">
                        <input type="text" name="pre-address-field" class="form-control" id="pre-address-field" placeholder="Present Address">
                        <input type="text" name="tin-field" class="form-control" id="tin-field" placeholder="TIN">
                        <input type="text" name="sss-field" class="form-control" id="sss-field" placeholder="SSS">
                        <input type="text" name="hdmf-field" class="form-control" id="hdmf-field" placeholder="HDMF">
                        <input type="text" name="phic-field" class="form-control" id="phic-field" placeholder="PHIC">
                        <input type="text" name="username-field" class="form-control" id="username-field" placeholder="Username">
                        <input type="password" name="recent-pass-field" class="form-control" id="recent-pass-field" placeholder="Old Password"><br>
                        <input type="password" name="password-field" class="form-control" id="password-field" placeholder="New Password">
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-theme btn-block" id="btn-update">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->

    <!-- modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="upload-modal" class="modal fade" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="edit-modal-title">Upload Photo </h4>
                </div>
                <div class="modal-body">
                    <form id="upload-form">
                        <input type="file" name="photo">
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-theme btn-block" id="btn-upload">
                        <img width="20px" height="20px" src="{{ asset('preloader/loading.gif') }}" alt="" style="display: none;" id="load">
                        Upload
                    </button>
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
            myProfile();
            loadDepartment();
            loadBranch();

            function myProfile() {
                var id = '{{ Auth::user()->id }}';
                $.ajax({
                    type: 'ajax',
                    url: '{{ url("/employeeProfile") }}',
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        $('#photo').attr('src', '{{ asset("assets/profilePictures") }}/' + response['profile_picture']);

                        $('#emp-id').html('<a>'+ response['employee_no'] +'</a>').click(function(){
                            $('#edit-form').attr('action', '{{ url("/update/employeeNo") }}/' + id);

                            $('#emp-id-field').show().val(response['employee_no']);
                            $('#full-name').hide();
                            $('#birthdate-field').hide();
                            $('#department-field').hide();
                            $('#position-field').hide();
                            $('#branch-field').hide();
                            $('#status-field').hide();
                            $('#contact-field-1').hide();
                            $('#contact-field-2').hide();
                            $('#email-field').hide();
                            $('#perm-address-field').hide();
                            $('#pre-address-field').hide();
                            $('#tin-field').hide();
                            $('#sss-field').hide();
                            $('#hdmf-field').hide();
                            $('#phic-field').hide();
                            $('#skype-field').hide();
                            $('#username-field').hide();
                            $('#password-field').hide();
                            $('#recent-pass-field').hide();
                            $('#date-hired-field').hide();

                            $('#edit-modal').modal('show');
                        });
                        $('#fullname').html('<a>'+ response['full_name'] +'</a>').click(function(){
                            $('#edit-form').attr('action', '{{ url("/update/fullName") }}/' + id);

                            $('#emp-id-field').hide();
                            $('#full-name').show();
                                $('#firstname-field').val(response['first_name']);
                                $('#middlename-field').val(response['middle_name']);
                                $('#lastname-field').val(response['last_name']);
                            $('#birthdate-field').hide();
                            $('#department-field').hide();
                            $('#position-field').hide();
                            $('#branch-field').hide();
                            $('#status-field').hide();
                            $('#contact-field-1').hide();
                            $('#contact-field-2').hide();
                            $('#email-field').hide();
                            $('#perm-address-field').hide();
                            $('#pre-address-field').hide();
                            $('#tin-field').hide();
                            $('#sss-field').hide();
                            $('#hdmf-field').hide();
                            $('#phic-field').hide();
                            $('#skype-field').hide();
                            $('#username-field').hide();
                            $('#password-field').hide();
                            $('#recent-pass-field').hide();
                            $('#date-hired-field').hide();

                            $('#edit-modal').modal('show');
                        });
                        $('#birthdate').html('<a>'+ response['birthdate'] +'</a>').click(function(){
                            $('#edit-form').attr('action', '{{ url("/update/birthdate") }}/' + id);

                            $('#emp-id-field').hide();
                            $('#full-name').hide();
                            $('#birthdate-field').show();
                            $('#department-field').hide();
                            $('#position-field').hide();
                            $('#branch-field').hide();
                            $('#status-field').hide();
                            $('#contact-field-1').hide();
                            $('#contact-field-2').hide();
                            $('#email-field').hide();
                            $('#perm-address-field').hide();
                            $('#pre-address-field').hide();
                            $('#tin-field').hide();
                            $('#sss-field').hide();
                            $('#hdmf-field').hide();
                            $('#phic-field').hide();
                            $('#skype-field').hide();
                            $('#username-field').hide();
                            $('#password-field').hide();
                            $('#recent-pass-field').hide();
                            $('#date-hired-field').hide();

                            $('#edit-modal').modal('show');
                        });
                        $('#department').html('<a>' + response['department'] + '</a>').click(function(){
                            $('#edit-form').attr('action', '{{ url("/update/department") }}/' + id);

                            $('#emp-id-field').hide();
                            $('#full-name').hide();
                            $('#birthdate-field').hide();
                            $('#department-field').show();
                            $('#position-field').show();
                            $('#branch-field').hide();
                            $('#status-field').hide();
                            $('#contact-field-1').hide();
                            $('#contact-field-2').hide();
                            $('#email-field').hide();
                            $('#perm-address-field').hide();
                            $('#pre-address-field').hide();
                            $('#tin-field').hide();
                            $('#sss-field').hide();
                            $('#hdmf-field').hide();
                            $('#phic-field').hide();
                            $('#skype-field').hide();
                            $('#username-field').hide();
                            $('#password-field').hide();
                            $('#recent-pass-field').hide();
                            $('#date-hired-field').hide();

                            $('#edit-modal').modal('show');
                        });
                        $('#position').html('<a>' + response['position'] + '</a>').click(function(){
                            $('#edit-form').attr('action', '{{ url("/update/department") }}/' + id);

                            $('#emp-id-field').hide();
                            $('#full-name').hide();
                            $('#birthdate-field').hide();
                            $('#department-field').show();
                            $('#position-field').show();
                            $('#branch-field').hide();
                            $('#status-field').hide();
                            $('#contact-field-1').hide();
                            $('#contact-field-2').hide();
                            $('#email-field').hide();
                            $('#perm-address-field').hide();
                            $('#pre-address-field').hide();
                            $('#tin-field').hide();
                            $('#sss-field').hide();
                            $('#hdmf-field').hide();
                            $('#phic-field').hide();
                            $('#skype-field').hide();
                            $('#username-field').hide();
                            $('#password-field').hide();
                            $('#recent-pass-field').hide();
                            $('#date-hired-field').hide();

                            $('#edit-modal').modal('show');
                        });
                        $('#branch').html('<a>' + response['branch'] + '</a>').click(function(){
                            $('#edit-form').attr('action', '{{ url("/update/branch") }}/' + id);

                            $('#emp-id-field').hide();
                            $('#full-name').hide();
                            $('#birthdate-field').hide();
                            $('#department-field').hide();
                            $('#position-field').hide();
                            $('#branch-field').show();
                            $('#status-field').hide();
                            $('#contact-field-1').hide();
                            $('#contact-field-2').hide();
                            $('#email-field').hide();
                            $('#perm-address-field').hide();
                            $('#pre-address-field').hide();
                            $('#tin-field').hide();
                            $('#sss-field').hide();
                            $('#hdmf-field').hide();
                            $('#phic-field').hide();
                            $('#skype-field').hide();
                            $('#username-field').hide();
                            $('#password-field').hide();
                            $('#recent-pass-field').hide();
                            $('#date-hired-field').hide();

                            $('#edit-modal').modal('show');
                        });
                        $('#c-status').html('<a>' + response['civil_status'] + '</a>').click(function(){
                            $('#edit-form').attr('action', '{{ url("/update/status") }}/' + id);

                            $('#emp-id-field').hide();
                            $('#full-name').hide();
                            $('#birthdate-field').hide();
                            $('#department-field').hide();
                            $('#position-field').hide();
                            $('#branch-field').hide();
                            $('#status-field').show();
                            $('#contact-field-1').hide();
                            $('#contact-field-2').hide();
                            $('#email-field').hide();
                            $('#perm-address-field').hide();
                            $('#pre-address-field').hide();
                            $('#tin-field').hide();
                            $('#sss-field').hide();
                            $('#hdmf-field').hide();
                            $('#phic-field').hide();
                            $('#skype-field').hide();
                            $('#username-field').hide();
                            $('#password-field').hide();
                            $('#recent-pass-field').hide();
                            $('#date-hired-field').hide();

                            $('#edit-modal').modal('show');
                        });
                        $('#contact-1').html('<a>' + response['contact_1'] + '</a>').click(function(){
                            $('#edit-form').attr('action', '{{ url("/update/contact1") }}/' + id);

                            $('#emp-id-field').hide();
                            $('#full-name').hide();
                            $('#birthdate-field').hide();
                            $('#department-field').hide();
                            $('#position-field').hide();
                            $('#branch-field').hide();
                            $('#status-field').hide();
                            $('#contact-field-1').show().val(response['contact_1']);
                            $('#contact-field-2').hide();
                            $('#email-field').hide();
                            $('#perm-address-field').hide();
                            $('#pre-address-field').hide();
                            $('#tin-field').hide();
                            $('#sss-field').hide();
                            $('#hdmf-field').hide();
                            $('#phic-field').hide();
                            $('#skype-field').hide();
                            $('#username-field').hide();
                            $('#password-field').hide();
                            $('#recent-pass-field').hide();
                            $('#date-hired-field').hide();

                            $('#edit-modal').modal('show');
                        });
                        $('#contact-2').html('<a>' + response['contact_2'] + '</a>').click(function(){
                            $('#edit-form').attr('action', '{{ url("/update/contact2") }}/' + id);

                            $('#emp-id-field').hide();
                            $('#full-name').hide();
                            $('#birthdate-field').hide();
                            $('#department-field').hide();
                            $('#position-field').hide();
                            $('#branch-field').hide();
                            $('#status-field').hide();
                            $('#contact-field-1').hide();
                            $('#contact-field-2').show().val(response['contact_2']);
                            $('#email-field').hide();
                            $('#perm-address-field').hide();
                            $('#pre-address-field').hide();
                            $('#tin-field').hide();
                            $('#sss-field').hide();
                            $('#hdmf-field').hide();
                            $('#phic-field').hide();
                            $('#skype-field').hide();
                            $('#username-field').hide();
                            $('#password-field').hide();
                            $('#recent-pass-field').hide();
                            $('#date-hired-field').hide();

                            $('#edit-modal').modal('show');
                        });
                        $('#date-hired').html('<a>' + response['date_hired'] + '</a>').click(function(){
                            $('#edit-form').attr('action', '{{ url("/update/datehired") }}/' + id);

                            $('#emp-id-field').hide();
                            $('#full-name').hide();
                            $('#birthdate-field').hide();
                            $('#department-field').hide();
                            $('#position-field').hide();
                            $('#branch-field').hide();
                            $('#status-field').hide();
                            $('#contact-field-1').hide();
                            $('#contact-field-2').hide();
                            $('#email-field').hide();
                            $('#perm-address-field').hide();
                            $('#pre-address-field').hide();
                            $('#tin-field').hide();
                            $('#sss-field').hide();
                            $('#hdmf-field').hide();
                            $('#phic-field').hide();
                            $('#skype-field').hide();
                            $('#username-field').hide();
                            $('#password-field').hide();
                            $('#recent-pass-field').hide();
                            $('#date-hired-field').show();

                            $('#edit-modal').modal('show');
                        });
                        $('#pre-address').html('<a>' + response['present_address'] + '</a>').click(function(){
                            $('#edit-form').attr('action', '{{ url("/update/preAddress") }}/' + id);

                            $('#emp-id-field').hide();
                            $('#full-name').hide();
                            $('#birthdate-field').hide();
                            $('#department-field').hide();
                            $('#position-field').hide();
                            $('#branch-field').hide();
                            $('#status-field').hide();
                            $('#contact-field-1').hide();
                            $('#contact-field-2').hide();
                            $('#email-field').hide();
                            $('#perm-address-field').hide();
                            $('#pre-address-field').show().val(response['present_address']);
                            $('#tin-field').hide();
                            $('#sss-field').hide();
                            $('#hdmf-field').hide();
                            $('#phic-field').hide();
                            $('#skype-field').hide();
                            $('#username-field').hide();
                            $('#password-field').hide();
                            $('#recent-pass-field').hide();
                            $('#date-hired-field').hide();

                            $('#edit-modal').modal('show');
                        });
                        $('#per-address').html('<a>' + response['permanent_address'] + '</a>').click(function(){
                            $('#edit-form').attr('action', '{{ url("/update/permAddress") }}/' + id);

                            $('#emp-id-field').hide();
                            $('#full-name').hide();
                            $('#birthdate-field').hide();
                            $('#department-field').hide();
                            $('#position-field').hide();
                            $('#branch-field').hide();
                            $('#status-field').hide();
                            $('#contact-field-1').hide();
                            $('#contact-field-2').hide();
                            $('#email-field').hide();
                            $('#perm-address-field').show().val(response['permanent_address']);
                            $('#pre-address-field').hide();
                            $('#tin-field').hide();
                            $('#sss-field').hide();
                            $('#hdmf-field').hide();
                            $('#phic-field').hide();
                            $('#skype-field').hide();
                            $('#username-field').hide();
                            $('#password-field').hide();
                            $('#recent-pass-field').hide();
                            $('#date-hired-field').hide();

                            $('#edit-modal').modal('show');
                        });
                        $('#skype').html('<a>' + response['skype'] + '</a>').click(function(){
                            $('#edit-form').attr('action', '{{ url("/update/skype") }}/' + id);

                            $('#emp-id-field').hide();
                            $('#full-name').hide();
                            $('#birthdate-field').hide();
                            $('#department-field').hide();
                            $('#position-field').hide();
                            $('#branch-field').hide();
                            $('#status-field').hide();
                            $('#contact-field-1').hide();
                            $('#contact-field-2').hide();
                            $('#email-field').hide();
                            $('#perm-address-field').hide();
                            $('#pre-address-field').hide();
                            $('#tin-field').hide();
                            $('#sss-field').hide();
                            $('#hdmf-field').hide();
                            $('#phic-field').hide();
                            $('#skype-field').show().val(response['skype']);
                            $('#username-field').hide();
                            $('#password-field').hide();
                            $('#recent-pass-field').hide();
                            $('#date-hired-field').hide();

                            $('#edit-modal').modal('show');
                        });
                        $('#email').html('<a>' + response['email'] + '</a>').click(function(){
                            $('#edit-form').attr('action', '{{ url("/update/email") }}/' + id);

                            $('#emp-id-field').hide();
                            $('#full-name').hide();
                            $('#birthdate-field').hide();
                            $('#department-field').hide();
                            $('#position-field').hide();
                            $('#branch-field').hide();
                            $('#status-field').hide();
                            $('#contact-field-1').hide();
                            $('#contact-field-2').hide();
                            $('#email-field').show().val(response['email']);
                            $('#perm-address-field').hide();
                            $('#pre-address-field').hide();
                            $('#tin-field').hide();
                            $('#sss-field').hide();
                            $('#hdmf-field').hide();
                            $('#phic-field').hide();
                            $('#skype-field').hide();
                            $('#username-field').hide();
                            $('#password-field').hide();
                            $('#recent-pass-field').hide();
                            $('#date-hired-field').hide();

                            $('#edit-modal').modal('show');
                        });
                        $('#tin').html('<a>' + response['tin'] + '</a>').click(function () {
                            $('#edit-form').attr('action', '{{ url("/update/tin") }}/' + id);

                            $('#emp-id-field').hide();
                            $('#full-name').hide();
                            $('#birthdate-field').hide();
                            $('#department-field').hide();
                            $('#position-field').hide();
                            $('#branch-field').hide();
                            $('#status-field').hide();
                            $('#contact-field-1').hide();
                            $('#contact-field-2').hide();
                            $('#email-field').hide();
                            $('#perm-address-field').hide();
                            $('#pre-address-field').hide();
                            $('#tin-field').show().val(response['tin']);
                            $('#sss-field').hide();
                            $('#hdmf-field').hide();
                            $('#phic-field').hide();
                            $('#skype-field').hide();
                            $('#username-field').hide();
                            $('#password-field').hide();
                            $('#recent-pass-field').hide();
                            $('#date-hired-field').hide();

                            $('#edit-modal').modal('show');
                        });
                        $('#sss').html('<a>' + response['sss'] + '</a>').click(function () {
                            $('#edit-form').attr('action', '{{ url("/update/sss") }}/' + id);

                            $('#emp-id-field').hide();
                            $('#full-name').hide();
                            $('#birthdate-field').hide();
                            $('#department-field').hide();
                            $('#position-field').hide();
                            $('#branch-field').hide();
                            $('#status-field').hide();
                            $('#contact-field-1').hide();
                            $('#contact-field-2').hide();
                            $('#email-field').hide();
                            $('#perm-address-field').hide();
                            $('#pre-address-field').hide();
                            $('#tin-field').hide();
                            $('#sss-field').show().val(response['sss']);
                            $('#hdmf-field').hide();
                            $('#phic-field').hide();
                            $('#skype-field').hide();
                            $('#username-field').hide();
                            $('#password-field').hide();
                            $('#recent-pass-field').hide();
                            $('#date-hired-field').hide();

                            $('#edit-modal').modal('show');
                        });
                        $('#hdmf').html('<a>' + response['hdmf'] + '</a>').click(function () {
                            $('#edit-form').attr('action', '{{ url("/update/hdmf") }}/' + id);

                            $('#emp-id-field').hide();
                            $('#full-name').hide();
                            $('#birthdate-field').hide();
                            $('#department-field').hide();
                            $('#position-field').hide();
                            $('#branch-field').hide();
                            $('#status-field').hide();
                            $('#contact-field-1').hide();
                            $('#contact-field-2').hide();
                            $('#email-field').hide();
                            $('#perm-address-field').hide();
                            $('#pre-address-field').hide();
                            $('#tin-field').hide();
                            $('#sss-field').hide();
                            $('#hdmf-field').show().val(response['hdmf']);
                            $('#phic-field').hide();
                            $('#skype-field').hide();
                            $('#username-field').hide();
                            $('#password-field').hide();
                            $('#recent-pass-field').hide();
                            $('#date-hired-field').hide();

                            $('#edit-modal').modal('show');
                        });
                        $('#phic').html('<a>' + response['phic'] + '</a>').click(function () {
                            $('#edit-form').attr('action', '{{ url("/update/phic") }}/' + id);

                            $('#emp-id-field').hide();
                            $('#full-name').hide();
                            $('#birthdate-field').hide();
                            $('#department-field').hide();
                            $('#position-field').hide();
                            $('#branch-field').hide();
                            $('#status-field').hide();
                            $('#contact-field-1').hide();
                            $('#contact-field-2').hide();
                            $('#email-field').hide();
                            $('#perm-address-field').hide();
                            $('#pre-address-field').hide();
                            $('#tin-field').hide();
                            $('#sss-field').hide();
                            $('#hdmf-field').hide();
                            $('#phic-field').show().val(response['phic']);
                            $('#skype-field').hide();
                            $('#username-field').hide();
                            $('#password-field').hide();
                            $('#recent-pass-field').hide();
                            $('#date-hired-field').hide();

                            $('#edit-modal').modal('show');
                        });

                        var vl = (response['VL'] / response['total_VL']) * 100;
                        var sl = (response['SL'] / response['total_SL']) * 100;
                        var pto = (response['PTO'] / response['total_PTO']) * 100;
                        console.log(pto);
                        $('#VL').width(vl + '%');
                        $('#VL-text').html(response['VL'] + '/' + response['total_VL']);
                        $('#SL').width(sl + '%');
                        $('#SL-text').html(response['SL'] + '/' + response['total_SL']);
                        $('#PTO').width(pto + '%');
                        $('#PTO-text').html(response['PTO'] + '/' + response['total_PTO']);
                        $('#OT-text').html('<b>'+response['OT']+'</b>');
                        $('#OB-text').html('<b>'+response['OB']+'</b>');
                    }
                });
            }

            $('#btn-update').click(function() {
               var url = $('#edit-form').attr('action');
               var formData = new FormData($('#edit-form')[0]);

               $.ajax({
                   type: 'ajax',
                   url: url,
                   method: 'post',
                   data: formData,
                   dataType: 'json',
                   processData: false,
                   contentType: false,
                   success: function(response){
                       myProfile();
                       $('#edit-modal').modal('hide');
                   }
               });
            });

            $('#department-field').click(function() {
                loadPosition($(this).val());
            });

            $('#photo').click(function() {
                $('#upload-form').attr('action', '{{ url("/upload/photo") }}');
                $('#upload-modal').modal('show');
            });

            $('#btn-upload').click(function() {
                var url = $('#upload-form').attr('action');
                var formData = new FormData($('#upload-form')[0]);

                $.ajax({
                    type: 'ajax',
                    url: url,
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#load').show();
                    },
                    success: function(response) {
                        $('#load').hide();
                        $('#upload-modal').modal('hide');
                        myProfile();
                    }
                });
            });

            function loadBranch()
            {
                $.ajax({
                    type: 'ajax',
                    url: '{{ url("/helper/branch") }}',
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        var html = '';
                        $.each(response, function(i, branch) {
                            html += '' +
                                '<option value="'+ branch['id'] +'">'+ branch['name'] +'</option>';
                        });

                        $('#branch-field').html(html);
                    }
                });
            }

            function loadDepartment()
            {
                $.ajax({
                    type: 'ajax',
                    url: '{{ url("/helper/department") }}',
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        var html = '';
                        $.each(response, function(i, department) {
                            html += '' +
                                '<option value="'+ department['id'] +'">'+ department['name'] +'</option>';
                        });

                        $('#department-field').html(html);
                    }
                });
            }

            function loadPosition(id)
            {
                $.ajax({
                    type: 'ajax',
                    url: '{{ url("/helper/position") }}/' + id,
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        var html = '<option value="">Select Position</option>';
                        $.each(response, function(i, position) {
                            html += '<option value="'+ position['id'] +'">'+ position['name'] +'</option>';
                        });
                        $('#position-field').html(html);
                    }
                });
            }
        });
    </script>
@endsection