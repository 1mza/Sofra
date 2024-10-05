<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\PaymentMethod;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentMethodController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PaymentMethod::class, 'payment_method');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::when(request()->has('search'),function ($query){
            $filteredColumns = ['name','description'];
            $query->where(function($query) use($filteredColumns){
                foreach ($filteredColumns as $filteredColumn){
                    $query->orWhere($filteredColumn,'like','%'.request('search').'%');
                }
            })->orWhereHas('seller',function($query) {
                $query->where('restaurant_name','like','%'.request('search').'%');
            });
        })->with('seller')->latest()->simplePaginate(10);
        return view('admin-panel.payment-methods.index', compact('paymentMethods'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sellers = Seller::all();
        return view('admin-panel.payment-methods.create' ,compact('sellers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'seller_id' => ['required',Rule::exists('sellers','id')],
            'name' => ['required','string','max:255',Rule::unique('payment_methods','name')],
            'description' => ['nullable','string'],
        ]);
        $paymentMethod = PaymentMethod::create($attributes);
        return redirect()->route('payment-methods.index')->with('success',$paymentMethod->seller->restaurant_name." Payment method created successfully");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        $sellers = Seller::all();
        return view('admin-panel.payment-methods.edit',compact(['paymentMethod','sellers']));
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $paymentMethod)
    {
        return view('admin-panel.payment-methods.show', compact('paymentMethod'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentMethod $paymentMethod)
    {
        $attributes = request()->validate([
            'seller_id' => ['sometimes',Rule::exists('sellers','id')],
            'name' => ['sometimes','string','max:255'],
            'description' => ['sometimes','string'],
        ]);
        $paymentMethod->update($attributes);
        return redirect()->route('payment-methods.index')->with('success',$paymentMethod->seller->restaurant_name." Payment method updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return redirect()->route('payment-methods.index')->with('success',$paymentMethod->seller->restaurant_name." Payment method deleted successfully");
    }
}
