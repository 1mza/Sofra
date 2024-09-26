<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Neighbourhood;
use Illuminate\Http\Request;

class NeighbourhoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Neighbourhoods = Neighbourhood::when(request()->has('city_id'),function ($query){
            $query->where('city_id',request()->city_id);
        })->get();
        return responseJson(1, "success", $Neighbourhoods);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
