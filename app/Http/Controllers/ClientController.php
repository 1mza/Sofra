<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Client;
use App\Models\Neighbourhood;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::when(request()->has('search'), function ($query) {
            $filteredColumns = ['name', 'email', 'phone', 'created_at'];
            $query->where(function ($query) use ($filteredColumns) {
                foreach ($filteredColumns as $column) {
                    $query->orWhere($column, 'LIKE', '%' . request('search') . '%');
                }
            })->orWhereHas('city', function ($query) {
                $query->where('name', 'LIKE', '%' . request('search') . '%');
            })->orWhereHas('neighbourhood', function ($query) {
                $query->where('name', 'LIKE', '%' . request('search') . '%');
            });
        })->with(['city','neighbourhood'])->latest()->simplePaginate(10);
        return view('admin-panel.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::all();
        $neighbourhoods = Neighbourhood::all();
        return view('admin-panel.clients.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('clients', 'email')],
            'phone' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
            'city_id' => ['required', Rule::exists('cities', 'id')],
            'neighbourhood_id' => ['required', Rule::exists('neighbourhoods', 'id')],
        ]);
        $attributes['password'] = bcrypt($attributes['password']);
        $client = Client::create($attributes);
        $client->api_token = Str::random(60);
        $client->save();
        return redirect()->route('clients.index')->with('success', "Client $client->name created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return view('admin-panel.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $cities = City::all();
        $neighbourhoods = Neighbourhood::all();
        return view('admin-panel.clients.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $attributes = $request->validate([
            'name' => ['sometimes'],
            'email' => ['sometimes', 'email', Rule::unique('clients', 'email')->ignore($client->id)],
            'phone' => ['sometimes', 'string'],
            'city_id' => ['sometimes', 'integer', Rule::exists('cities', 'id')],
            'neighbourhood_id' => ['sometimes', 'integer', Rule::exists('neighbourhoods', 'id')],
        ]);

        if (request()->filled('password')) {
            request()->validate([
                'password' => ['sometimes', 'confirmed', Password::min(8)],
            ]);
            $attributes['password'] = bcrypt($request->input('password'));
        } else {
            unset($attributes['password']);
        }

        $client->update($attributes);

        return redirect()->route('clients.index')->with('success', "Client $client->name updated successfully");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', "Client $client->name deleted successfully");
    }
}
