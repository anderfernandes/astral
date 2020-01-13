@component('mail::layout')
    

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ \App\Setting::find(1)->organization}} {{ date('Y') }}. All rights reserved.
            <br>
            {{ \App\Setting::find(1)->phone }} |
            [{{ \App\Setting::find(1)->website }}](http://{{ \App\Setting::find(1)->website }}) |
            [Astral](https://astral.anderfernandes.com)
        @endcomponent
    @endslot
@endcomponent
