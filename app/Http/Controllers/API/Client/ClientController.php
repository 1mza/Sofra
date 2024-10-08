<?php

namespace App\Http\Controllers\API\Client;

use App\Events\OrderCreatedEvent;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ContactUs;
use App\Models\Offer;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Seller;
use App\Models\SettingsText;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    public function profile()
    {
        try {
            $attributes = request()->validate([
                'name' => ['sometimes'],
                'email' => ['sometimes', 'email', Rule::unique('clients', 'email')->ignore(request()->user()->id)],
                'phone' => ['sometimes', 'string'],
                'password' => ['sometimes', 'confirmed', Password::min(8)],
                'city_id' => ['sometimes', 'integer', Rule::exists('cities', 'id')],
                'neighbourhood_id' => ['sometimes', 'integer', Rule::exists('neighbourhoods', 'id')],
            ]);
            if (isset($attributes['password'])) {
                $attributes['password'] = Hash::make($attributes['password']);
            }
            $client = auth()->user();
            $client->update($attributes);
            return responseJson(1, "Client Updated Successfully.", $client);
        } catch (ValidationException $e) {
            return responseJson(0, $e->getMessage(), $e->errors());
        }
    }

    public function createOrder()
    {
        try {
            $orderAttribute = request()->validate([
                'seller_id' => ['required', 'integer', Rule::exists('sellers', 'id')],
                'notes' => ['nullable', 'string'],
                'delivery_address' => ['required', 'string'],
                'payment_method_id' => ['required', 'integer', Rule::exists('payment_methods', 'id'),
                    function ($attribute, $value, $fail) {
                        if (!PaymentMethod::where('id', $value)
                            ->where('seller_id', request('seller_id'))
                            ->exists()) {
                            $fail('Payment Method not found for this seller.');
                        }
                    }
                ],
            ]);
            $orderPivotAttribute = request()->validate([
                'product_id' => ['required', 'array'],
                'product_id.*' => ['integer', Rule::exists('products', 'id'),
                    function ($attribute, $value, $fail) {
                        if (!Product::where('id', $value)
                            ->where('seller_id', request('seller_id'))
                            ->exists()) {
                            $fail('Product not found for this seller.');
                        }
                    }],
                'quantity' => ['required', 'array'],
                'quantity.*' => ['integer'],
                'special_note' => ['nullable', 'array'],
                'special_note.*' => ['nullable', 'string'],
            ]);
            $client = Client::findOrFail(auth()->user()->id);
            $seller = Seller::findOrFail(request('seller_id'));
            $productsPrice = 0;
            foreach ($orderPivotAttribute['product_id'] as $key => $productId) {
                $product = Product::findOrFail($productId);
                $productsPrice += $orderPivotAttribute['quantity'][$key] * $product->price;
            }
            if ($productsPrice < $seller->minimum_charge) {
                return responseJson(0, 'Total price is less than the seller minimum charge.');
            }
            $order = $client->orders()->create($orderAttribute);


            foreach ($orderPivotAttribute['product_id'] as $key => $productId) {
                $product = Product::findOrFail($productId);
                $order->products()->attach($productId, [
                    'quantity' => $orderPivotAttribute['quantity'][$key],
                    'special_note' => $orderPivotAttribute['special_note'][$key] ?? null,
                    'price' => $product->price * $orderPivotAttribute['quantity'][$key],
                ]);
            }
            $totalPrice = $order->products()->sum('order_product.price') + $seller->delivery_fees;
            $order->update(['total' => $totalPrice]);
//            event(new OrderCreatedEvent($client, $seller));

            OrderCreatedEvent::dispatch($client, $seller, $order);

            return responseJson(1, 'Order created successfully', $order->load('products'));


        } catch (ValidationException $e) {
            return responseJson(0, $e->getMessage(), $e->errors());
        }
    }

    public function restaurants()
    {
        try {
            request()->validate([
                'restaurant_name' => ['sometimes', 'string'],
                'city_id' => ['sometimes', 'integer', Rule::exists('cities', 'id')],
            ]);
            $restaurants = Seller::when(request()->filled('restaurant_name') ||
                request()->filled('city_id'), function ($query) {
                $query->when(request()->filled('city_id'), function ($query) {
                    $query->where('city_id', request()->city_id);
                })
                    ->when(request()->filled('restaurant_name'), function ($query) {
                        $query->where('restaurant_name', request()->restaurant_name);
                    });
            })->select([
                'id',
                'restaurant_name',
                'status',
                'minimum_charge',
                'delivery_fees'
            ])
                ->withAvg('reviews', 'rating')
                ->latest()
                ->paginate(10)
                ->map(function ($restaurant) {
                    $restaurant->reviews_avg_rating = $restaurant->reviews_avg_rating ?? 0;
                    return $restaurant;
                });
            return responseJson(1, "Restaurant List", $restaurants);
        } catch (ValidationException $e) {
            return responseJson(0, $e->getMessage(), $e->errors());
        }
    }

    public function singleRestaurant(Seller $seller)
    {
        return responseJson(1, "Restaurant Detail", $seller);
    }

    public function restaurantMenu(Seller $seller)
    {
        $products = $seller->products()->get();
        return responseJson(1, "Restaurant Menu Detail", $products);
    }

    public function restaurantReviews(Seller $seller)
    {
        $reviews = $seller->reviews()->get();
        return responseJson(1, "Restaurant Reviews Detail", $reviews);
    }

    public function addReview(Seller $seller)
    {
        try {

            $attributes = request()->validate([
                'rating' => ['nullable', 'integer', 'between:1,10'],
                'comment' => ['nullable', 'string'],
            ]);
            $client = auth()->user();
            if (request()->filled('comment') || request()->filled('rating')) {
                $review = $client->reviews()->create([
                    'seller_id' => $seller->id,
                    'comment' => $attributes['comment'] ?? null,
                    'rating' => $attributes['rating'] ?? null,
                ]);
                return responseJson(1, "Review Detail", $review ?? 'Please fill one at least.');
            }
            return responseJson(0, "Review not saved", 'Please fill one at least.');
        } catch (ValidationException $e) {
            return responseJson(0, $e->getMessage(), $e->errors());
        }
    }

    public function aboutApp()
    {
        $aboutApp = SettingsText::select('about_app')->first();
        return responseJson(1, "About App", $aboutApp);
    }

    public function offers()
    {
        $offers = Offer::with('seller')->latest()->get()->map(function ($offer) {
            return [
                'id' => $offer->id,
                'restaurant image' => $offer->seller->image,
                'offer name' => $offer->name,
            ];
        });
        return responseJson(1, "Offers retrieved successfully.", $offers);
    }

    public function offerInfo(string $id)
    {
        $offer = Offer::with('seller')->findOrFail($id);
        return response()->json([
            'status' => 1,
            'message' => 'Offer retrieved successfully.',
            'data' => $offer,
        ]);
    }

    public function contactUs()
    {
        try {
            $attributes = request()->validate([
                'name' => ['required', 'string'],
                'email' => ['required', 'email'],
                'phone' => ['required', 'string'],
                'message' => ['required', 'string'],
                'type' => ['required', Rule::in(['complaint', 'inquiry', 'suggestion'])],
            ]);
            $contact = ContactUs::create($attributes);
            return responseJson(1, "Contact details added successfully.", $contact);
        } catch (ValidationException $e) {
            return responseJson(0, $e->getMessage(), $e->errors());
        }
    }

}
