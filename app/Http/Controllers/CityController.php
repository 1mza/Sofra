<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Neighbourhood;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CityController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(City::class, 'city');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::when(request()->has('search'),function ($query){
            $query->where('name','like','%'.request('search').'%');
        })->latest()->simplePaginate(10);
        return view('admin-panel.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-panel.cities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'name' => ['required','string','max:255',Rule::unique('cities','name')],
        ]);
        $city = City::create($attributes);
        return redirect()->route('cities.show',compact('city'))->with('success',$attributes['name']." City created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        return view('admin-panel.cities.show',compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        return view('admin-panel.cities.edit',compact('city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        $attributes = request()->validate([
            'name' => ['required','string','max:255',Rule::unique('cities','name')->ignore($city->id)],
        ]);
        $city->update($attributes);
        return redirect()->route('cities.show')->with('success',$attributes['name']." City updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('cities.index')->with('success',$city->name." City deleted successfully");
    }
}
