<?php

namespace App\Http\Controllers\API\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Commission;
use App\Models\SettingsText;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

;

class SellerController extends Controller
{
    public function profile()
    {
        try {
            $attributes = request()->validate([
                'restaurant_name' => ['sometimes'],
                'email' => ['sometimes', 'email', Rule::unique('sellers', 'email')->ignore(request()->user()->id)],
                'phone' => ['sometimes', 'string'],
                'password' => ['sometimes', 'confirmed', Password::min(8)],
                'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
                'city_id' => ['sometimes', 'integer', Rule::exists('cities', 'id')],
                'neighbourhood_id' => ['sometimes', 'integer', Rule::exists('neighbourhoods', 'id')],
                'minimum_charge' => ['sometimes', 'integer'],
                'delivery_fees' => ['sometimes', 'integer'],
                'delivery_phone' => ['sometimes', 'integer'],
                'delivery_whatsapp' => ['sometimes', 'integer'],
                'status' => ['sometimes', Rule::in(['open', 'closed'])],
            ]);
            if (isset($attributes['password'])) {
                $attributes['password'] = Hash::make($attributes['password']);
            }
            if (request()->hasFile('image')) {
                $attributes['image'] = request()->file('image')->store('sellers');
            }
            $seller = auth()->user();
            $seller->update($attributes);
            return responseJson(1, "Seller Updated Successfully.", $seller);
        } catch (ValidationException $e) {
            return responseJson(0, $e->getMessage(), $e->errors());
        }
    }

    public function categories()
    {
        $categories = Category::all();
        return responseJson(1, "Categories retrieved success", $categories);
    }

    public function payCommission()
    {
        try {
            $attributes = request()->validate([
                'amount_paid' => ['required', 'integer', 'gt:0'],
                'note' => ['sometimes', 'string'],
            ]);
            $seller = auth()->user();
            $commission = Commission::where('seller_id', $seller->id)->latest()->first();
            $remaining_amount = $commission ? $commission->remaining_amount - $attributes['amount_paid']
                : $seller->app_commissions - request('amount_paid');
            if ($remaining_amount < 0) {
                return responseJson(0, "Amount paid exceeds the seller's commission due.");
            }
            $commission = $seller->commissions()->create([
                'amount_paid' => $attributes['amount_paid'],
                'note' => $attributes['note'] ?? null,
                'remaining_amount' => $remaining_amount
            ]);
            return responseJson(1, "Commission paid success", $commission);
        } catch (ValidationException $e) {
            return responseJson(0, $e->getMessage(), $e->errors());
        }
    }

    public function commissionInfo(){
        $seller = auth()->user();
        $commission = Commission::where('seller_id', $seller->id)->latest()->first();
        $amountPaid = Commission::where('seller_id', $seller->id)->sum('amount_paid');
        return responseJson(1,'Commissions info retrieved successfully', [
            'restaurant sales' => $seller->restaurant_sales,
            'app commissions' => $seller->app_commissions,
            'amount paid' => $amountPaid,
            'remaining amount' => $commission->remaining_amount ?? $seller->app_commissions
        ]);
    }

    public function commissionText(){
        $aboutApp = SettingsText::select('commission_text')->first();
        return responseJson(1, "About App", $aboutApp);
    }



}
