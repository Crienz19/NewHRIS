@extends('layout.app-auth')

@section('title', 'HRIS Registration')

@section('content')
    <form class="form-register" id="register-form">

        <h2 class="form-register-heading">HRIS Registration</h2>
        <div class="login-wrap">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Personal Details</a></li>
                <li><a data-toggle="tab" href="#menu1">Company Details</a></li>
                <li><a data-toggle="tab" href="#menu2">Authentication Details</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <br>
                    <div class="row">
                        <div class="col-xs-12 col-md-4">
                            <label for="first-name">First Name: </label>
                            <input type="text" class="form-control" name="first-name" placeholder="First Name">
                            <span id="first-name-error" style="color: red;"></span>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <label for="middle-name">Middle Name: </label>
                            <input type="text" class="form-control" name="middle-name" placeholder="Middle Name">
                            <span id="middle-name-error" style="color: red;"></span>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <label for="last-name">Last Name: </label>
                            <input type="text" class="form-control" name="last-name" placeholder="Last Name">
                            <span id="last-name-error" style="color: red"></span>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <label for="birthdate">Birth Date: </label>
                            <input type="date" class="form-control" name="birthdate" placeholder="Birth Date">
                            <span id="birthdate-error" style="color: red"></span>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="status">Civil Status: </label>
                            <select name="status" id="status" class="form-control">
                                <option value="" selected>--- SELECT ---</option>
                                <option value="SINGLE">SINGLE</option>
                                <option value="MARRIED">MARRIED</option>
                                <option value="WIDOWED">WIDOWED</option>
                            </select>
                            <span id="status-error" style="color: red;"></span>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <label for="pre-address">Present Address: </label>
                            <input type="text" class="form-control" name="pre-address" placeholder="Present Address">
                            <span id="pre-address-error" style="color: red;"></span>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="perm-address">Permanent Address: </label>
                            <input type="text" class="form-control" name="perm-address" placeholder="Permanent Address">
                            <span id="perm-address-error" style="color: red;"></span>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <label for="contact-1">Contact #1: </label>
                            <input type="text" class="form-control" name="contact-1" placeholder="e.g: 09123456789" maxlength="11">
                            <span id="contact-1-error" style="color: red;"></span>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="contact-2">Contact #2: </label>
                            <input type="text" class="form-control" name="contact-2" placeholder="e.g: 09123456789" maxlength="11">
                            <span id="contact-2-error" style="color: red;"></span>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-12 col-md-3">
                            <label for="tin">TIN: </label>
                            <input type="text" class="form-control" name="tin" placeholder="TIN Number">
                            <span id="tin-error" style="color: red;"></span>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <label for="sss">SSS: </label>
                            <input type="text" class="form-control" name="sss" placeholder="SSS Number">
                            <span id="sss-error" style="color: red;"></span>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <label for="hdmf">HDMF: </label>
                            <input type="text" class="form-control" name="hdmf" placeholder="HDMF">
                            <span id="hdmf-error" style="color: red;"></span>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <label for="phic">PHIC: </label>
                            <input type="text" class="form-control" name="phic" placeholder="PHIC">
                            <span id="phic-error" style="color: red;"></span>
                        </div>
                    </div>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <br>
                    <div class="row">
                        <div class="col-xs-12 col-md-4">
                            <label for="employee-id">Employee ID: </label>
                            <input type="text" class="form-control" name="employee-id">
                            <span id="employee-id-error" style="color: red;"></span>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <label for="branch">Branch Assignment: </label>
                            <select name="branch" id="branch" class="form-control">
                                <option value="" selected>SELECT</option>
                            </select>
                            <span id="branch-error" style="color: red;"></span>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <label for="date-hired">Date Hired</label>
                            <input type="date" name="date-hired" class="form-control" id="date-hired">
                            <span id="date-hired-error" style="color: red;"></span>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <label for="department">Department: </label>
                            <select name="department" id="department" class="form-control">
                                <option value="" selected>Select</option>
                            </select>
                            <span id="department-error" style="color: red;"></span>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="position">Position: </label>
                            <input type="text" name="position" class="form-control">
                            <span id="position-error" style="color: red;"></span>
                        </div>
                    </div>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <br>
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <label for="name">Username: </label>
                            <input type="text" name="name" class="form-control" placeholder="Username" autofocus>
                            <span id="error-user" style="color: red;"></span>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <label for="email">E-mail: </label>
                            <input type="text" name="email" class="form-control" placeholder="E-mail">
                            <span id="error-email" style="color: red;"></span>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="skype">Skype ID: </label>
                            <input type="text" name="skype" class="form-control" placeholder="Skype ID">
                            <span id="skype-error" style="color: red;"></span>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <label for="Password">Password: </label>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            <span id="error-password" style="color: red;"></span>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="password-confirmation">Confirm Password: </label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                            <span id="error-cpassword" style="color: red;"></span>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <button id="btn-action" class="btn btn-theme btn-block" type="submit">
                                <i class="fa fa-lock" id="lock"></i>
                                <img width="20px" height="20px" src="{{ asset('preloader/loading.gif') }}" alt="" style="display: none;" id="load">
                                Sign Up
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection

@section('script')
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/intro.jpg", {speed: 500});
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function(){
            loadDepartment();
            loadBranch();
            $('#register-form').submit( function(e) {
                e.preventDefault();

                var formData = new FormData($(this)[0]);

                $.ajax({
                    type: 'ajax',
                    url: '{{ route("register") }}',
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function(response){
                        $('#btn-action').prop('disabled', true);
                        $('#load').show();
                        $('#lock').hide();
                    },
                    success: function(response) {
                        console.log(response);
                        $('#load').hide();
                        $('#lock').show();
                        window.location.href = '{{ url("/welcome") }}';
                    },
                    error: function(response) {
                        var error = response.responseJSON.errors;

                        $('#error-user').html(error['name']);
                        $('#error-email').html(error['email']);
                        $('#skype-error').html(error['skype']);
                        $('#error-password').html(error['password']);
                        $('#error-cpassword').html(error['password']);
                        $('#first-name-error').html(error['first-name']);
                        $('#middle-name-error').html(error['middle-name']);
                        $('#last-name-error').html(error['last-name']);
                        $('#birthdate-error').html(error['birthdate']);
                        $('#status-error').html(error['status']);
                        $('#pre-address-error').html(error['pre-address']);
                        $('#perm-address-error').html(error['perm-address']);
                        $('#contact-1-error').html(error['contact-1']);
                        $('#contact-2-error').html(error['contact-2']);
                        $('#tin-error').html(error['tin']);
                        $('#sss-error').html(error['sss']);
                        $('#hdmf-error').html(error['hdmf']);
                        $('#phic-error').html(error['phic']);
                        $('#employee-id-error').html(error['employee-id']);
                        $('#branch-error').html(error['branch']);
                        $('#date-hired-error').html(error['date-hired']);
                        $('#department-error').html(error['department']);
                        $('#position-error').html(error['position']);

                        $('#btn-action').prop('disabled', false);
                        $('#load').hide();
                        $('#lock').show();

                    }
                });
            });

            $('#department').click(function() {
                loadPosition($(this).val());
            });

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

                        $('#department').append(html);
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
                        $('#position').html(html);
                    }
                });
            }

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

                        $('#branch').append(html);
                    }
                });
            }
        });
    </script>
@endsection