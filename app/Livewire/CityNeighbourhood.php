<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\Neighbourhood;
use Livewire\Component;

class CityNeighbourhood extends Component
{
    public $cities;
    public $city_id;
    public $neighbourhoods;

    public function mount()
    {
        $this->cities = City::all();
    }

    public function updatedCityId($value)
    {
        $this->city_id = $value;
        $this->neighbourhoods = Neighbourhood::where('city_id', $this->city_id)->get();
    }

    public function render()
    {
        return view('livewire.city-neighbourhood');
    }

}

