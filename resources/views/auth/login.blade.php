@extends('layout.app-auth')

@section('title', 'Login')

@section('content')
    <form class="form-login" action="{{ route('login') }}" method="POST">
        {{ csrf_field() }}
        <h2 class="form-login-heading">HRIS Login</h2>
        <div class="login-wrap">
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
            <input type="text" name="username" class="form-control" placeholder="Username" autofocus>
            <span id="error-user" style="color: red;"></span>
            <br>
            <input type="password" name="password" class="form-control" placeholder="Password">
            <span id="error-password" style="color: red;"></span>
            <label class="checkbox">
                <span class="pull-right">
                    <a data-toggle="modal" href="login.html#myModal" style="display: none"> Forgot Password?</a>
                </span>
            </label>
            <button class="btn btn-theme btn-block" type="submit">
                <i class="fa fa-lock" id="lock"></i>
                <img width="20px" height="20px" src="{{ asset('preloader/loading.gif') }}" alt="" style="display: none;" id="load">
                SIGN IN
            </button>
            <hr>

            <div class="registration">
                Don't have an account yet?<br/>
                <a href="#" id="register">
                    Create an account
                </a>
            </div>

        </div>
    </form>

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <form action="" id="forgot-form">
            {{ csrf_field() }}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Forgot Password ?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Enter your e-mail address below to reset your password.</p>
                        <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-theme" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- modal -->

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="verify-modal" class="modal fade">
        <form action="" id="verify-form">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Verification</h4>
                    </div>
                    <div class="modal-body">
                        <p>Enter PIN Code to register</p>
                        <input type="password" name="code" placeholder="PIN" class="form-control placeholder-no-fix">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-theme btn-block" id="btn-verify">Verify</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- modal -->
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/jquery.backstretch.min.js') }}"></script>
    <script>
        $.backstretch("{{ asset('assets/img/intro.jpg') }}", {speed: 500});
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $('#register').click(function() {
                $('#verify-modal').modal('show');
            });

            $('#btn-verify').click(function(e) {
                e.preventDefault();
                if($('input[name=code]').val() == 'z1ptr4v3l') {
                    window.location.href = '{{ route("show.register") }}';
                } else {
                    alert('Invalid PIN');
                }
            });
        });
    </script>
@endsection

