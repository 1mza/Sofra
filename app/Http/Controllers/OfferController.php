<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Offer::when(request()->has('search'), function ($query) {
            $filteredColumns = ['name', 'brief_description', 'start_date', 'end_date'];
            $query->where(function ($query) use ($filteredColumns) {
                foreach ($filteredColumns as $column) {
                    $query->orWhere($column, 'LIKE', '%' . request('search') . '%');
                }
            })->orWhereHas('seller', function ($query) {
                $query->where('restaurant_name', 'LIKE', '%' . request('search') . '%');
            });
        })->latest()->simplePaginate(10);
        return view('admin-panel.offers.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sellers = Seller::all();
        return view('admin-panel.offers.create', compact('sellers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'seller_id' => ['required', Rule::exists('sellers', 'id')],
            'name' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'brief_description' => ['required', 'string'],
            'start_date' => ['required', 'date', 'after:yesterday'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ]);
        $attributes['image'] = $attributes['image']->store('offers');
        $offer = Offer::create($attributes);
        return redirect()->route('offers.index')->with('success', "Offer for " . $offer->seller->restaurant_name . " created successfully");
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer)
    {
        $sellers = Seller::all();
        return view('admin-panel.offers.edit', compact(['offer','sellers']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offer $offer)
    {
        $attributes = request()->validate([
            'seller_id' => ['sometimes', Rule::exists('sellers', 'id')],
            'name' => ['sometimes', 'string'],
            'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'brief_description' => ['sometimes', 'string'],
            'start_date' => ['sometimes', 'date', 'after:yesterday'],
            'end_date' => ['sometimes', 'date', 'after_or_equal::start_date'],
        ]);
        if (request()->hasFile('image')) {
            $attributes['image'] = $attributes['image']->store('offers');
        }else{
            $attributes['image'] = $offer->image;
        }
        $offer->update($attributes);
        return redirect()->route('offers.index')->with('success', "Offer for " . $offer->seller->restaurant_name . " updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();
        return redirect()->route('offers.index')->with('success', "Offer for " . $offer->seller->restaurant_name . " deleted successfully");
    }
}
