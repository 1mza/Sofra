<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{

    public function newOrders()
    {
        if (auth()->check()) {
            $orders = Order::where('order_status', 'pending')->with('products')->get();
            if (request()->has(['order_id', 'action'])) {
                try {
                    request()->validate([
                        'order_id' => ['required', Rule::exists('orders', 'id')],
                        'action' => ['required', Rule::in(['accepted', 'refused'])],
                    ]);
                    $order = Order::find(request()->order_id);
                    $order->update(['order_status' => request()->action]);

                    return responseJson(1, "Order status changed successfully.", $order);
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
            $orders = Order::where('order_status', 'accepted')->with('products')->get();
            if (request()->has(['order_id', 'action'])) {
                try {
                    request()->validate([
                        'order_id' => ['required', Rule::exists('orders', 'id')],
                        'action' => ['required', Rule::in(['delivered'])],
                    ]);
                    $order = Order::find(request()->order_id);
                    if ($order->order_status == 'accepted') {
                        $order->update(['order_status' => request()->action]);
                        return responseJson(1, "Order status changed successfully.", $order);
                    } else {
                        return responseJson(0, "Only accepted orders can change to delivered.", $order);
                    }

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
            $orders = Order::whereIn('order_status', ['delivered','refused','declined'])->with('products')->get();
            return responseJson(1, "New Orders (Delivered, Refused, Declined) retrieved successfully.", $orders);
        }
        return responseJson(0, "Unauthenticated.");
    }

}
