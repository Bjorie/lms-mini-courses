@props([
    'href',
])

<a
    href="{{ $href }}"
    {{ $attributes->class([
        'mb-6 inline-flex items-center gap-2 font-medium text-blue-600 transition-colors hover:text-blue-800',
    ]) }}
>
    <span aria-hidden="true">←</span>

    <span>
        {{ $slot }}
    </span>
</a>