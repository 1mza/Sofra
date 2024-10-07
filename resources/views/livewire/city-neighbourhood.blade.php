<div>
    <x-forms.select wire:model.live="city_id" label="City" name="city_id">
        <option selected >Select City</option>
        @foreach($cities as $cityn)
            <option {{request('city_id')==$cityn->id ? 'selected':''}} value="{{ $cityn->id }}">{{ $cityn->name }}</option>
        @endforeach
    </x-forms.select>
    @if($city_id)
        <x-forms.select label="Neighbourhood" name="neighbourhood_id">
            <option selected >Select Neighbourhood</option>
            @foreach($neighbourhoods as $neighbourhood)
                <option value="{{ $neighbourhood->id }}">{{ $neighbourhood->name }}</option>
            @endforeach
        </x-forms.select>
    @endif
</div>
