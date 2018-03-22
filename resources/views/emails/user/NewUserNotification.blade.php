@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            HRIS Email Notification
        @endcomponent
    @endslot
    {{-- Body --}}
    <center># New User Has Been Registered</center>

    {{ $data->full_name }} is registered at {{ $data->created_at }}
    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')

            @endcomponent
        @endslot
    @endisset
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}.
        @endcomponent
    @endslot
@endcomponent