@props([
    'href',
])

<a
    href="{{ $href }}"
    class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium mb-6"
>
    ← {{ $slot }}
</a>