<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Neighbourhood;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SellerController extends Controller
{

    public function __construct(){
        $this->authorizeResource(Seller::class,'seller');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sellers = Seller::when(request()->has('search'), function ($query) {
            $filteredColumns = ['restaurant_name', 'email', 'phone', 'delivery_phone', 'delivery_whatsapp'
                , 'minimum_charge', 'restaurant_sales', 'app_commissions', 'status', 'created_at'];
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
        return view('admin-panel.sellers.index', compact('sellers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::all();
        $neighbourhoods = Neighbourhood::all();
        $categories = Category::all();
        return view('admin-panel.sellers.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'restaurant_name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('sellers', 'email')],
            'phone' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
            'city_id' => ['required', Rule::exists('cities', 'id')],
            'neighbourhood_id' => ['required', Rule::exists('neighbourhoods', 'id')],
            'minimum_charge' => ['required', 'integer', 'min:1'],
            'delivery_fees' => ['required', 'integer', 'min:1'],
            'delivery_phone' => ['required', 'string'],
            'delivery_whatsapp' => ['required', 'string'],
            'status' => ['required', Rule::in(['open', 'closed'])],
        ]);
        $categories = request()->validate([
            'category_id' => ['required', 'array'],
            'category_id,*' => [Rule::exists('categories', 'id')],
        ]);
        $attributes['password'] = bcrypt($attributes['password']);
        $attributes['image'] = $attributes['image']->store('sellers');
        $seller = Seller::create($attributes);
        $seller->api_token = Str::random(60);
        $seller->save();
        $seller->categories()->attach($categories['category_id']);
        return redirect()->route('sellers.show', compact('seller'))->with('success', "Seller $seller->restaurant_name created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Seller $seller)
    {
        return view('admin-panel.sellers.show', compact('seller'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seller $seller)
    {
        $cities = City::all();
        $neighbourhoods = Neighbourhood::all();
        $categories = Category::all();
        return view('admin-panel.sellers.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seller $seller)
    {
        $attributes = $request->validate([
            'restaurant_name' => ['sometimes'],
            'email' => ['sometimes', 'email', Rule::unique('sellers', 'email')->ignore($seller->id)],
            'phone' => ['sometimes', 'string'],
            'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'city_id' => ['sometimes', 'integer', Rule::exists('cities', 'id')],
            'neighbourhood_id' => ['sometimes', 'integer', Rule::exists('neighbourhoods', 'id')],
            'minimum_charge' => ['sometimes', 'integer'],
            'delivery_fees' => ['sometimes', 'integer'],
            'delivery_phone' => ['sometimes', 'string'],
            'delivery_whatsapp' => ['sometimes', 'string'],
            'status' => ['sometimes', Rule::in(['open', 'closed'])],
        ]);
        if ($request->filled('password')) {
            request()->validate([
                'password' => ['sometimes', 'confirmed', Password::min(8)],
            ]);
            $attributes['password'] = bcrypt($request->input('password'));
        } else {
            unset($attributes['password']);
        }
        if ($request->hasFile('image')) {
            $attributes['image'] = $request->file('image')->store('sellers');
        }

        $seller->update($attributes);

        return redirect()->route('sellers.show', compact('seller'))->with('success', "Seller $seller->restaurant_name updated successfully");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seller $seller)
    {
        $seller->delete();
        return redirect()->route('sellers.index')->with('success', "Seller $seller->restaurant_name deleted successfully");
    }
}
