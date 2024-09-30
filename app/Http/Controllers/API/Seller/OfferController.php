<?php

namespace App\Http\Controllers\API\Seller;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OfferController extends Controller
{

    public function index()
    {
        if (auth()->check()) {
            $offers = Offer::where('seller_id', auth()->user()->id)->get();
            return responseJson(1, "Offers retrieved successfully.", $offers);
        }
        return responseJson(1, "Unauthenticated.");

    }


    public function createOffer(Request $request)
    {
        if (auth()->check()) {
            try {
                $attributes = request()->validate([
                    'name' => ['required', 'string'],
                    'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
                    'brief_description' => ['required', 'string'],
                    'start_date' => ['required', 'date', 'after:yesterday'],
                    'end_date' => ['required', 'date', 'after_or_equal:start_date'],
                ]);
                $attributes['image'] = $attributes['image']->store('offers');
                $seller = auth()->user();
                $offer = $seller->offers()->create($attributes);
                return responseJson(1, "Offer Created successfully.", $offer);
            } catch (ValidationException $e) {
                return responseJson(0, $e->getMessage(), $e->errors());
            }
        }
        return responseJson(1, "Unauthenticated.");
    }

    public function updateOffer(Offer $offer)
    {
        if (auth()->check()) {
            try {
                $attributes = request()->validate([
                    'seller_id' => ['sometimes', 'integer'],
                    'name' => ['sometimes', 'string'],
                    'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
                    'brief_description' => ['sometimes', 'string'],
                    'start_date' => ['sometimes', 'date', 'after:yesterday'],
                    'end_date' => ['sometimes', 'date', 'after_or_equal:start_date'],
                ]);
                if (request()->hasFile('image')) {
                    $attributes['image'] = $attributes['image']->store('offers');
                }
                $offer->update($attributes);
                return responseJson(1, "Offer updated successfully.", $offer);
            } catch (ValidationException $e) {
                return responseJson(0, $e->getMessage(), $e->errors());
            }
        }
        return responseJson(1, "Unauthenticated.");
    }


    public function deleteOffer(Offer $offer)
    {
        if (auth()->check()) {
            $offer->delete();
            return responseJson(1, "Offer deleted successfully.");
        }
        return responseJson(0, "Unauthenticated.");
    }
}
