<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function currentOrders()
    {
        if (auth()->check()) {
            $client = auth()->user();
            $orders = Order::where('order_status', 'pending')
                ->where('client_id', $client->id)
                ->with('seller', 'products')
                ->get()
                ->map(function ($order) {
                    return [
                        'image' => $order->seller->image,
                        'restaurant_name' => $order->seller->restaurant_name,
                        'id' => $order->id,
                        'total' => $order->total,
                    ];
                });
            if (request()->has(['order_id']) && request()->has(['action'])) {
                try {
                    request()->validate([
                        'order_id' => ['required', Rule::exists('orders', 'id'),
                            function ($attribute, $value, $fail) use ($client) {
                                if (!Order::where('id', $value)
                                    ->where('client_id', $client->id)
                                    ->where('order_status', 'pending')
                                    ->exists()) {
                                    $fail('Order not found.');
                                }
                            }],
                        'action' => ['required', Rule::in(['delivered', 'refused'])],
                    ]);
                    $order = Order::find(request()->order_id);
                    $order->update(['order_status' => request()->action]);

                    return responseJson(1, "Order status changed successfully.", $order->load('client','products'));
                } catch (ValidationException $e) {
                    return responseJson(0, $e->getMessage(), $e->errors());
                }
            }
            return responseJson(1, 'Current orders retrieved successfully.', $orders);
        };
        return responseJson(0, 'Unauthenticated.');
    }


    public function PastOrders()
    {
        if (auth()->check()) {
            $orders = Order::whereIn('order_status', ['accepted', 'delivered', 'refused', 'declined'])
                ->where('client_id', auth()->user()->id)->with('products', 'seller')
                ->get()
                ->map(function ($order) {
                    return [
                        'image' => $order->seller->image,
                        'restaurant_name' => $order->seller->restaurant_name,
                        'id' => $order->id,
                        'total' => $order->total,
                    ];
                });
            return responseJson(1, 'Past orders retrieved successfully.', $orders);
        };
        return responseJson(0, 'Unauthenticated.');
    }

}
