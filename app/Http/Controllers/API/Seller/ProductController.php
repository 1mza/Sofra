<?php

namespace App\Http\Controllers\API\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{

    public function index()
    {
        if (auth()->check()) {
            $products = Product::all();
            return responseJson(1,"Products retrieved successfully.",$products);
        }
        return responseJson(1,"Unauthenticated.");

    }


    public function createProduct(Request $request)
    {
        if (auth()->check()) {
            try {
                $attributes = request()->validate([
                    'name' => ['required', 'string'],
                    'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
                    'brief_description' => ['required', 'string'],
                    'price' => ['required', 'integer'],
                    'offer_price' => ['required', 'integer'],
                    'preparation_time' => ['required', 'string'],
                ]);
                $attributes['image'] = $attributes['image']->store('products');
                $seller = auth()->user();
                $product = $seller->products()->create($attributes);
                return responseJson(1, "Product created successfully.", $product);
            } catch (ValidationException $e) {
                return responseJson(0, $e->getMessage(), $e->errors());
            }
        }
        return responseJson(1,"Unauthenticated.");
    }

    public function updateProduct(Product $product)
    {
        if (auth()->check()) {
            try {
                $attributes = request()->validate([
                    'name' => ['sometimes', 'string'],
                    'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
                    'brief_description' => ['sometimes', 'string'],
                    'price' => ['sometimes', 'integer'],
                    'offer_price' => ['sometimes', 'integer'],
                    'preparation_time' => ['sometimes', 'integer'],
                ]);
                if (request()->hasFile('image')) {
                    $attributes['image'] = $attributes['image']->store('products');
                }
                $product->update($attributes);
                return responseJson(1, "Product updated successfully.", $product);
            } catch (ValidationException $e) {
                return responseJson(0, $e->getMessage(), $e->errors());
            }
        }
        return responseJson(1,"Unauthenticated.");
    }


    public function deleteProduct(Product $product)
    {
        if (auth()->check()) {
            $product->delete();
            return responseJson(1,"Product deleted successfully.");
        }
        return responseJson(0,"Unauthenticated.");
    }
}
