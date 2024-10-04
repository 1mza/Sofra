<?php

namespace App\Http\Controllers;

use App\Models\ContactLink;
use http\Encoding\Stream\Inflate;

class ContactLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contact_links = ContactLink::all(); // Fetches the first record
        return view('admin-panel.contact-links.index', compact('contact_links'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (ContactLink::count() == 0) {
            return view('admin-panel.contact-links.create');
        } else {
            abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $attributes = request()->validate([
            'phone' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'whatsapp_link' => ['nullable', 'string'],
            'x_link' => ['nullable', 'string'],
            'instagram_link' => ['nullable', 'string'],
            'youtube_link' => ['nullable', 'string'],
            'linkedin_link' => ['nullable', 'string'],
            'facebook_link' => ['nullable', 'string'],
            'google_link' => ['nullable', 'string'],
            'android_app_link' => ['nullable', 'string'],
            'apple_app_link' => ['nullable', 'string'],
        ]);
        ContactLink::create($attributes);
        return redirect()->route('contact-links.index')->with('success', "Contact links created successfully");
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactLink $contact_link)
    {
        return view('admin-panel.contact-links.edit', compact('contact_link'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ContactLink $contact_link)
    {
        // Validate the request data
        $attributes = request()->validate([
            'phone' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'whatsapp_link' => ['nullable', 'string'],
            'x_link' => ['nullable', 'string'],
            'instagram_link' => ['nullable', 'string'],
            'youtube_link' => ['nullable', 'string'],
            'linkedin_link' => ['nullable', 'string'],
            'facebook_link' => ['nullable', 'string'],
            'google_link' => ['nullable', 'string'],
            'android_app_link' => ['nullable', 'string'],
            'apple_app_link' => ['nullable', 'string'],
        ]);

        // Update the contact link using the model instance
        $contact_link->update($attributes);

        // Redirect back to the contact-links index page with a success message
        return redirect()->route('contact-links.index')->with('success', 'Contact links updated successfully');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactLink $contact_link)
    {
        $contact_link->delete();
        return redirect()->route('contact-links.index')->with('success', "Contact Links deleted successfully");
    }
}
