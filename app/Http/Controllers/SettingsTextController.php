<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Offer;
use App\Models\SettingsText;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SettingsTextController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = SettingsText::when(request()->has('search'), function ($query) {
            $filteredColumns = ['about_app', 'commission_text'];
            $query->where(function ($query) use ($filteredColumns) {
                foreach ($filteredColumns as $column) {
                    $query->orWhere($column, 'LIKE', '%' . request('search') . '%');
                }
            });
        })->latest()->get();
        return view('admin-panel.settings.index', compact('settings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SettingsText $setting)
    {
        return view('admin-panel.settings.edit',compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SettingsText $setting)
    {
        $attributes = request()->validate([
            'about_app' => ['sometimes','string'],
            'commission_text' => ['sometimes','string'],
        ]);
        $setting->update($attributes);
        return redirect()->route('settings.index')->with('success',"Settings updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();
        return redirect()->route('offers.index')->with('success', "Offer for " . $offer->seller->restaurant_name . " deleted successfully");
    }
}
