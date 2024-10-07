<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <x-forms.input label="Password" wire:model.live.debounce.100ms="password" type="password" name="password"/>
    @if($password)
        <span class="font-semibold">Password Strength: </span> {{ $strengthLevels[$strengthScore] ?? 'weak' }}
        <div>
            <progress value="{{ $strengthScore }}" max="4"  class="w-full"></progress>
        </div>
    @endif
    <x-forms.input label="Password Confirmation" type="password" name="password_confirmation"/>
</div>
