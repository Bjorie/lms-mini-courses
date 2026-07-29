@props([
    'value' => null,
])

<label
    {{ $attributes->class([
        'block text-sm font-medium text-gray-700',
    ]) }}
>
    {{ $value ?? $slot }}
</label>