<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Client;
use App\Models\Commission;
use App\Models\ContactUs;
use App\Models\Neighbourhood;
use App\Models\Offer;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        $clients = Client::count();
        $sellers = Seller::count();
        $cities = City::count();
        $neighbourhoods = Neighbourhood::count();
        $categories = Category::count();
        $users = User::count();
        $sellersInfo = Seller::all();
        $contacts = ContactUs::count();
        $commissions = Commission::count();
        $orders = Order::latest()->get();
        $offers = Offer::count();
        $paymentMethods = PaymentMethod::count();
        $latestBoughtProducts = Product::whereHas('orders', function ($query) use ($orders) {
            $query->whereIn('orders.id', $orders->take(3)->pluck('id'));
        })->get()->unique('id');
        $acceptedOrders = Order::where('order_status','accepted')->count();
        $refusedOrders = Order::where('order_status','refused')->count();
        $deliveredOrders = Order::where('order_status','delivered')->count();
        $declinedOrders = Order::where('order_status','declined')->count();
        return view('admin-landing-page',get_defined_vars());
    }
}
