<?php

namespace App\Http\Controllers\API\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{

    public function newOrders()
    {
        if (auth()->check()) {
            $orders = Order::where('order_status', 'pending')
                ->where('seller_id', auth()->user()->id)->with('products', 'client')
                ->get()
                ->map(function ($order) {
                    return [
                        'client_name' => $order->client->name,
                        'id' => $order->id,
                        'total' => $order->total,
                        'delivery_address' => $order->delivery_address,
                    ];
                });
            if (request()->has(['order_id']) && request()->has(['action'])) {
                try {
                    request()->validate([
                        'order_id' => ['required', Rule::exists('orders', 'id'),
                            function ($attribute, $value, $fail) {
                                if (!Order::where('id', $value)
                                    ->where('seller_id', auth()->user()->id)
                                    ->where('order_status', 'pending')
                                    ->exists()) {
                                    $fail('Order not found.');
                                }
                            }],
                        'action' => ['required', Rule::in(['accepted', 'refused'])],
                    ]);
                    $order = Order::find(request()->order_id);
                    $order->update(['order_status' => request()->action]);

                    return responseJson(1, "Order status changed successfully.", $order->load('client','products'));
                } catch (ValidationException $e) {
                    return responseJson(0, $e->getMessage(), $e->errors());
                }
            }
            return responseJson(1, "New Orders (Pending) retrieved successfully.", $orders);
        }
        return responseJson(0, "Unauthenticated.");
    }

    public function currentOrders()
    {
        if (auth()->check()) {
            $orders = Order::where('order_status', 'accepted')
                ->where('seller_id', auth()->user()->id)->with('products', 'client')
                ->get()
                ->map(function ($order) {
                    return [
                        'client_name' => $order->client->name,
                        'id' => $order->id,
                        'total' => $order->total,
                        'delivery_address' => $order->delivery_address,
                    ];
                });
            if (request()->has(['order_id']) && request()->has(['action'])) {
                try {
                    request()->validate([
                        'order_id' => ['required', Rule::exists('orders', 'id'),
                            function ($attribute, $value, $fail) {
                                if (!Order::where('order_status', 'accepted')
                                    ->where('seller_id', auth()->user()->id)
                                    ->where('id', $value)->exists()) {
                                    $fail('Order not found.');
                                }
                            }],
                        'action' => ['required', Rule::in(['delivered'])]
                    ]);
                    $order = Order::find(request()->order_id);
                    $order->update(['order_status' => request()->action]);
                    return responseJson(1, "Order status changed successfully.", $order->load('client','products'));

                } catch (ValidationException $e) {
                    return responseJson(0, $e->getMessage(), $e->errors());
                }
            }
            return responseJson(1, "New Orders (Accepted) retrieved successfully.", $orders);
        }
        return responseJson(0, "Unauthenticated.");
    }

    public function PastOrders()
    {
        if (auth()->check()) {
            $orders = Order::whereIn('order_status', ['delivered', 'refused', 'declined'])
                ->where('seller_id', auth()->user()->id)->with('products', 'client')
                ->get()
                ->map(function ($order) {
                    return [
                        'client_name' => $order->client->name,
                        'id' => $order->id,
                        'total' => $order->total,
                        'delivery_address' => $order->delivery_address,
                    ];
                });
            return responseJson(1, "New Orders (Delivered, Refused, Declined) retrieved successfully.", $orders);
        }
        return responseJson(0, "Unauthenticated.");
    }

}
