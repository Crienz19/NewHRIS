@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            HRIS Email Notification
        @endcomponent
    @endslot
    {{-- Body --}}
    #Filed By: {{ $data['fullname'] }}

    From: {{ $data['date_from'] }}
    To: {{ $data['date_to'] }}

    Time-In: {{ $data['time_in'] }}
    Time-Out: {{ $data['time_out'] }}

    Destination From: {{ $data['destination_from'] }}
    Destination To: {{ $data['destination_to'] }}

    Purpose:
    {{ $data['purpose'] }}

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