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

</body>
</html>
