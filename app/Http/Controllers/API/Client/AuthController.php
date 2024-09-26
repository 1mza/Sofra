<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\Client;
use App\Models\Token;
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
                'name' => ['required', 'string'],
                'email' => ['required', 'email', Rule::unique('clients', 'email')],
                'phone' => ['required', 'string'],
                'password' => ['required', 'confirmed', Password::min(8)],
                'city_id' => ['required', Rule::exists('cities', 'id')],
                'neighbourhood_id' => ['required', Rule::exists('neighbourhoods', 'id')]
            ]);
            $attributes['password'] = bcrypt($attributes['password']);
            $client = Client::create($attributes);
            $client->api_token = Str::random(60);
            $client->save();
            return responseJson(1, "Client Created Successfully.", $client);
        } catch (ValidationException $e) {
            return responseJson(0, $e->getMessage(), $e->errors());
        }
    }

    public function login()
    {
        try {
            request()->validate([
                'email' => ['required', 'email', Rule::exists('clients', 'email')],
                'password' => ['required', Password::min(8)],
            ]);
            $client = Client::where('email', request('email'))->first();
            if ($client) {
                if (Hash::check(request('password'), $client->password)) {
                    $client->api_token = Str::random(60);
                    $client->save();
                    return responseJson(1, "Client Login Successfully.", $client);
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
                'email' => ['required', 'email', Rule::exists('clients', 'email')],
            ]);
            $client = Client::where('email', request('email'))->first();
            if ($client) {
                $code = random_int(11111, 99999);
                $client->update([
                    'pin_code' => $code,
                    'pin_code_expires_at' => now()->addMinutes(30),
                ]);
                Mail::to($client->email)->send(new ResetPassword($code, $client));
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
            $client = Client::where('pin_code', request('pin_code'))->first();
            if ($client) {
                if ($client->pin_code_expires_at >= now()) {
                    if (!Hash::check(request('password'), $client->password)) {
                        $client->update([
                            'password' => bcrypt(request('password')),
                            'pin_code' => null,
                            'pin_code_expires_at' => null,
                        ]);
                        return responseJson(1, "Password reset successfully.", $client);
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

    public function registerToken()
    {
        try {
            request()->validate([
                'client_id' => ['required', Rule::exists('clients', 'id')],
                'token' => ['required', 'string'],
                'type' => ['required', Rule::in(['android', 'ios'])],
            ]);
            $token = Token::where('token', request('token'))->first();

            if ($token) {
                $token->update([
                    'token' => request('token'),
                    'type' => request('type'),
                ]);
                return responseJson(1, 'Token registered (Updated) successfully', $token);
            } else {
                $token = Token::create(request()->all());
                return responseJson(1, 'Token registered (Created) successfully', $token);
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
