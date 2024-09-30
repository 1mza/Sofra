@props(['label', 'name'])

<div>
    @if ($label)
        <x-forms.label :$name :$label />
    @endif

    <div class="inline">
        {{ $slot }}

        <x-forms.error :error="$errors->first($name)" />
    </div>
</div>