<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
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
}
