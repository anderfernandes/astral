<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ (new \App\Models\Setting())->first()->organization }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ (new \App\Models\Setting())->first()->organization }}. @lang('All rights reserved.')
Powered by [Astral](https://astral.anderfernandes.com).
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
