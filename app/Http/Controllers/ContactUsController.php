<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\Offer;
use Illuminate\Support\Facades\Gate;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::define('list contacts',function($user){
            return $user->hasPermissionTo('list contacts');
        });
        Gate::authorize('list contacts');
        $contacts = ContactUs::when(request()->has('search'), function ($query) {
            $filteredColumns = ['name', 'email', 'phone', 'message','type','created_at'];
            $query->where(function ($query) use ($filteredColumns) {
                foreach ($filteredColumns as $column) {
                    $query->orWhere($column, 'LIKE', '%' . request('search') . '%');
                }
            });
        })->latest()->simplePaginate(10);
        return view('admin-panel.contacts.index', compact('contacts'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public
    function destroy(Offer $offer)
    {
        Gate::define('delete contact',function($user){
            return $user->hasPermissionTo('delete contact');
        });
        Gate::authorize('delete contact');
        $offer->delete();
        return redirect()->route('offers.index')->with('success', "Offer for " . $offer->seller->restaurant_name . " deleted successfully");
    }
}
