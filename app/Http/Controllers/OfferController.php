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
        })->with('seller')->latest()->simplePaginate(10);
        return view('admin-panel.offers.index', compact('offers'));
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
