<!doctype html>
<html lang="{{ app()->getLocale() }}">
@include('partials._header')
<body>
<section id="container">
    @include('partials._nav')
    @include('partials._sidenav')
    <section id="main-content">
        <section class="wrapper">
            @yield('content')
        </section>
    </section>
</section>

@include('partials._footer')
@include('partials._javascript')
@yield('script')
<script>
    $(document).ready(function() {
        getSupLeavePending();
        getEmpLeavePending();
        getEmpOTPending();

        function getSupLeavePending() {
            $.ajax({
                type: 'ajax',
                url: `{{ url("/helper/sup/leave/Pending") }}`,
                method: 'get',
                dataType: 'json',
                success: function(response) {
                    $('#sup-pending').text(response === 0 ? '' : response);
                }
            });
        }

        function getEmpLeavePending() {
            $.ajax({
                type: 'ajax',
                url: `{{ url("/helper/emp/leave/Pending") }}`,
                method: 'get',
                dataType: 'json',
                success: function(response) {
                    $('#emp-leave-pending').text(response === 0 ? '' : response);
                }
            });
        }

        function getEmpOTPending() {
            $.ajax({
                type: 'ajax',
                url: `{{ url("/helper/emp/ot/Pending") }}`,
                method: 'get',
                dataType: 'json',
                success: function(response) {
                    $('#emp-ot-pending').text(response === 0 ? '' : response);
                }
            });
        }
    })
</script>
</body>
</html>
