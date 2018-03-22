@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            HRIS Email Notification
        @endcomponent
    @endslot
    {{-- Body --}}
    #Filed By: {{ $data['fullname'] }}

    Leave Type: {{ $data['type'] }}
    Pay Type: {{ $data['pay_type'] }}

    From: {{ $data['from'] }}
    To: {{ $data['to'] }}

    Reason:
        {{ $data['reason'] }}

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