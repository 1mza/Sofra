@props(['label', 'name', 'value' => '', 'checked' => false])

@php
    $defaults = [
        'type' => 'checkbox',
        'id' => $name . '_' . $value,
        'name' => $name . '[]',
        'value' => $value,
    ];

    if ($checked) {
        $defaults['checked'] = 'checked';
    }
@endphp

<x-forms.field :$label :$name>
    <div class="rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full">
        <input {{ $attributes->merge($defaults) }}>
        <span class="pl-1">{{ $label }}</span>
    </div>
</x-forms.field>