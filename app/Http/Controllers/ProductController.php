<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::when(request()->has('search'), function ($query) {
            $filteredColumns = ['name', 'brief_description', 'price', 'offer_price', 'preparation_time', 'created_at'];
            $query->where(function ($query) use ($filteredColumns) {
                foreach ($filteredColumns as $column) {
                    $query->orWhere($column, 'LIKE', '%' . request('search') . '%');
                }
            })->orWhereHas('seller', function ($query) {
                $query->where('restaurant_name', 'LIKE', '%' . request('search') . '%');
            });
        })->with('seller')->latest()->simplePaginate(10);
        return view('admin-panel.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sellers = Seller::all();
        return view('admin-panel.products.create', compact('sellers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $attributes = request()->validate([
            'seller_id' => ['required', Rule::exists('sellers', 'id')],
            'name' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'brief_description' => ['required', 'string'],
            'price' => ['required', 'integer'],
            'offer_price' => ['nullable', 'integer'],
            'preparation_time' => ['required', 'string'],
        ]);
        $attributes['image'] = $attributes['image']->store('products');
        $product = Product::create($attributes);
        return redirect()->route('products.index')->with('success', $attributes['name'] . " Product created successfully");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $sellers = Seller::all();
        return view('admin-panel.products.edit', compact('product','sellers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $attributes = request()->validate([
            'seller_id' => ['sometimes', Rule::exists('sellers', 'id')],
            'name' => ['sometimes', 'string'],
            'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'brief_description' => ['sometimes', 'string'],
            'price' => ['sometimes', 'integer'],
            'offer_price' => ['nullable', 'integer'],
            'preparation_time' => ['sometimes', 'string'],
        ]);
        if ($request->hasFile('image')) {
            $attributes['image'] = $attributes['image']->store('products');
        }
        $product->update($attributes);
        return redirect()->route('products.index')->with('success', $attributes['name'] . " Product updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', $product->name . " City deleted successfully");
    }
}
