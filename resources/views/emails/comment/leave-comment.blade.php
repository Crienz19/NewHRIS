@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            HRIS Email Notification
        @endcomponent
    @endslot
    {{-- Body --}}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                From: {{ $data->from }}
                To:   {{ $data->to }}

                Reason:
                    {{ $data->reason }}

                ----------------------------------------------------------------

                Comment:
                    {{ $data->comment }}

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