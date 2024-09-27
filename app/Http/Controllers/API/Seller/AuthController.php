<?php

namespace App\Http\Controllers\API\Seller;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register()
    {
        try {
            $attributes = request()->validate([
                'restaurant_name' => ['required', 'string'],
                'email' => ['required', 'email', Rule::unique('sellers', 'email')],
                'phone' => ['required', 'string'],
                'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
                'password' => ['required', 'confirmed', Password::min(8)],
                'city_id' => ['required', Rule::exists('cities', 'id')],
                'neighbourhood_id' => ['required', Rule::exists('neighbourhoods', 'id')],
                'minimum_charge' => ['required', 'integer', 'min:1'],
                'delivery_fees' => ['required', 'integer', 'min:1'],
                'delivery_phone' => ['required', 'string'],
                'delivery_whatsapp' => ['required', 'string'],
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
            return responseJson(1, "Seller Created Successfully.", [
                'Api Token'=> $seller->api_token,
                'Seller'=> $seller
            ]);
        } catch (ValidationException $e) {
            return responseJson(0, $e->getMessage(), $e->errors());
        }
    }

    public function login()
    {
        try {
            request()->validate([
                'email' => ['required', 'email', Rule::exists('sellers', 'email')],
                'password' => ['required', Password::min(8)],
            ]);
            $seller = Seller::where('email', request('email'))->first();
            if ($seller) {
                if (Hash::check(request('password'), $seller->password)) {
                    $seller->api_token = Str::random(60);
                    $seller->save();
                    return responseJson(1, "Seller Login Successfully.", [
                        'Api Token'=> $seller->api_token,
                        'Seller'=> $seller
                    ]);
                } else {
                    return responseJson(0, "Password is incorrect.");
                }
            } else {
                return responseJson(0, "These credentials does not exist in our records.");
            }
        } catch (ValidationException $e) {
            return responseJson(0, $e->getMessage(), $e->errors());
        }
    }

    public function resetPassword()
    {
        try {
            request()->validate([
                'email' => ['required', 'email', Rule::exists('sellers', 'email')],
            ]);
            $seller = Seller::where('email', request('email'))->first();
            if ($seller) {
                $code = random_int(11111, 99999);
                $seller->update([
                    'pin_code' => $code,
                    'pin_code_expires_at' => now()->addMinutes(30),
                ]);
                Mail::to($seller->email)->send(new ResetPassword($code, $seller));
                return responseJson(1, "Your password reset code has been sent to your email. This code is valid for 30 minutes.", ['code' => $code]);

            } else {
                return responseJson(0, "These credentials does not exist in our records.");
            }
        } catch (ValidationException $e) {
            return responseJson(0, $e->getMessage(), $e->errors());
        }
    }

    public function newPassword()
    {
        try {
            request()->validate([
                'pin_code' => ['required', 'integer', 'digits:5'],
                'password' => ['required', 'confirmed', Password::min(8)],
            ]);
            $seller = Seller::where('pin_code', request('pin_code'))->first();
            if ($seller) {
                if ($seller->pin_code_expires_at >= now()) {
                    if (!Hash::check(request('password'), $seller->password)) {
                        $seller->update([
                            'password' => bcrypt(request('password')),
                            'pin_code' => null,
                            'pin_code_expires_at' => null,
                        ]);
                        return responseJson(1, "Password reset successfully.", $seller);
                    } else {
                        return responseJson(0, "Sorry, Your new password match the old one, please try different one again.");
                    }
                } else {
                    return responseJson(0, "Sorry, Your reset code is out of time (30 minutes).");
                }
            } else {
                return responseJson(0, "Pin code is incorrect.");
            }
        } catch (ValidationException $e) {
            return responseJson(0, $e->getMessage(), $e->errors());
        }
    }

    public function logout()
    {
        if (auth()->check()) {
            auth()->user()->update(['api_token' => null]);
            return responseJson(1, 'Logged out successfully');
        }
        return responseJson(0, 'Unauthenticated');
    }

}
