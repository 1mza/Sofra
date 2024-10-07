<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Client;
use App\Models\Neighbourhood;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:viewAny,App\Models\Order')->only('index');
        $this->middleware('can:view,App\Models\Order')->only('show');
        $this->middleware('can:delete,App\Models\Order')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::when(request()->has('search'), function ($query) {
            $filteredColumns = ['notes', 'delivery_address', 'total','created_at'];
            $query->where(function ($query) use ($filteredColumns) {
                foreach ($filteredColumns as $column) {
                    $query->orWhere($column, 'LIKE', '%' . request('search') . '%');
                }
            })->orWhereHas('client', function ($query) {
                $query->where('name', 'LIKE', '%' . request('search') . '%');
            })->orWhereHas('seller', function ($query) {
                $query->where('restaurant_name', 'LIKE', '%' . request('search') . '%');
            })->orWhereHas('paymentMethod', function ($query) {
                $query->where('name', 'LIKE', '%' . request('search') . '%');
            });
        })->with(['client','seller','products','paymentMethod'])->latest()->simplePaginate(10);
        return view('admin-panel.orders.index', compact('orders'));
    }
    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('admin-panel.orders.show', ['order' => $order]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', "Order $order->id deleted successfully");
    }
}
