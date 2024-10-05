<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Neighbourhood;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NeighbourhoodController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Neighbourhood::class, 'neighbourhood');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $neighbourhoods = Neighbourhood::when(request()->has('search'),function ($query){
            $query->where('name','like','%'.request('search').'%')
            ->orWhereHas('city',function ($query){
                $query->where('name','like','%'.request('search').'%');
            });
        })->latest()->with('city')->simplePaginate(10);
        return view('admin-panel.neighbourhoods.index', compact('neighbourhoods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::all();
        return view('admin-panel.neighbourhoods.create',compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'city_id' => ['required',Rule::exists('cities','id')],
            'name' => ['required','string','max:255',Rule::unique('cities','name')],
        ]);
        $neighbourhood = Neighbourhood::create($attributes);
        return redirect()->route('neighbourhoods.show',compact('neighbourhood'))->with('success',$attributes['name']." Neighbourhood created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Neighbourhood $neighbourhood)
    {
        return view('admin-panel.neighbourhoods.show',compact('neighbourhood'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Neighbourhood $neighbourhood)
    {
        $cities = City::all();
        return view('admin-panel.neighbourhoods.edit',compact('neighbourhood','cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Neighbourhood $neighbourhood)
    {
        $attributes = request()->validate([
            'city_id' => ['required',Rule::exists('cities','id')],
            'name' => ['required','string','max:255',Rule::unique('cities','name')->ignore($neighbourhood->id)],
        ]);
        $neighbourhood->update($attributes);
        return redirect()->route('neighbourhoods.show',compact('neighbourhood'))->with('success',$attributes['name']." Neighbourhood updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Neighbourhood $neighbourhood)
    {
        $neighbourhood->delete();
        return redirect()->route('neighbourhoods.index')->with('success',$neighbourhood->name." Neighbourhood deleted successfully");
    }
}
