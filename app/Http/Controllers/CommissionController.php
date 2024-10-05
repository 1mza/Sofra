<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommissionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Commission::class, 'commission');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commissions = Commission::when(request()->has('search'), function ($query) {
            $filteredColumns = ['amount_paid', 'note', 'remaining_amount', 'created_at'];
            $query->where(function ($query) use ($filteredColumns) {
                foreach ($filteredColumns as $column) {
                    $query->orWhere($column, 'like', '%' . request('search') . '%');
                }
            })
                ->orWhereHas('seller', function ($query) {
                    $query->where('restaurant_name', 'like', '%' . request('search') . '%');
                });
        })->with('seller')
            ->orderBy('created_at', 'desc')
            ->orderBy('updated_at', 'desc')
            ->simplePaginate(10);

        return view('admin-panel.commissions.index', compact('commissions'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sellers = Seller::all();
        return view('admin-panel.commissions.create', compact('sellers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'seller_id' => ['required', 'integer', Rule::exists('sellers', 'id')],
            'amount_paid' => ['required', 'numeric', 'gt:0'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);
        $seller = Seller::findOrFail($attributes['seller_id']);
        $commission = Commission::where('seller_id', $attributes['seller_id'])->latest()->first();
        $remaining_amount = $commission ? $commission->remaining_amount - $attributes['amount_paid']
            : $seller->app_commissions - request('amount_paid');
        if ($remaining_amount < 0) {
            return responseJson(0, "Amount paid exceeds the seller's commission due.");
        }
        $commission = Commission::create([
            'seller_id' => $attributes['seller_id'],
            'amount_paid' => $attributes['amount_paid'],
            'note' => $attributes['note'] ?? null,
            'remaining_amount' => $remaining_amount
        ]);
        return redirect()->route('commissions.index', compact('commission'))->with('success', " Commission for $seller->restaurant_name created successfully");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commission $commission)
    {
        $sellers = Seller::all();
        return view('admin-panel.commissions.edit', compact('commission', 'sellers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commission $commission)
    {
        $attributes = request()->validate([
            'seller_id' => ['sometimes', 'integer', Rule::exists('sellers', 'id')],
            'amount_paid' => ['sometimes', 'numeric', 'gt:0'],
            'remaining_amount' => ['sometimes', 'numeric', 'gt:0'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);
        if (isset($attributes['amount_paid']) && $attributes['amount_paid'] != $commission->amount_paid) {
            $attributes['remaining_amount'] = $commission->remaining_amount + $commission->amount_paid - $attributes['amount_paid'];
        }
//        if (isset($attributes['remaining_amount'])) {
//            $commission->remaining_amount = $attributes['remaining_amount'];
//        }
        $commission->update($attributes);
        return redirect()->route('commissions.index')->with('success', " Commission for " . $commission->seller->restaurant_name . " updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commission $commission)
    {
        $commission->delete();
        return redirect()->route('commissions.index')->with('success', " Commission id  $commission->id  deleted successfully");
    }
}
