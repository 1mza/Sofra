@extends('layouts.admin-app')
@inject('contactLinks','App\Models\ContactLink')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/contact-links')}}">Contact Links</a></li>
            <li class="breadcrumb-item active"><a href="{{route('contact-links.edit', $contact_link)}}">Update Page</a></li>


        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-indigo"><i class="nav-icon fa fa-phone"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Update contact-links </span>
                <span class="info-box-number">ID: {{$contact_link->id}}</span>
            </div>
        </div>
    </div>
@endsection

@section('small_title')
@endsection
@section('content')

    <!-- Default box -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                Update form
            </h3>

        </div>
        <div class="card-body">
            <x-forms.form class="d-flex flex-column" method="post" action="{{route('contact-links.update', $contact_link)}}">
                @csrf
                @method('PATCH')
                <x-forms.input value="{{$contact_link->phone}}" label="Phone" name="phone"
                               placeholder="Enter phone ..."/>

                <x-forms.input value="{{$contact_link->email}}" label="Email" type="email" name="email"
                               placeholder="Enter email  ..."/>

                <x-forms.input value="{{$contact_link->whatsapp_link}}" label="Whatsapp Link" name="whatsapp_link"
                               placeholder="Enter whatsapp link ..."/>

                <x-forms.input value="{{$contact_link->x_link}}" label="X Link" name="x_link"
                               placeholder="Enter x link ..."/>

                <x-forms.input value="{{$contact_link->linkedin_link}}" label="LinkedIn Link" name="linkedin_link"
                               placeholder="Enter linkedin link ..."/>

                <x-forms.input value="{{$contact_link->facebook_link}}" label="Facebook Link" name="facebook_link"
                               placeholder="Enter facebook link ..."/>

                <x-forms.input value="{{$contact_link->youtube_link}}" label="Youtube Link" name="youtube_link"
                               placeholder="Enter youtube link ..."/>

                <x-forms.input value="{{$contact_link->instagram_link}}" label="Instagram Link" name="instagram_link"
                               placeholder="Enter instagram link ..."/>

                <x-forms.input value="{{$contact_link->google_link}}" label="Google Link" name="google_link"
                               placeholder="Enter google link ..."/>

                <x-forms.input value="{{$contact_link->android_app_link}}" label="Android App Link" name="android_app_link"
                               placeholder="Enter android app link ..."/>

                <x-forms.input value="{{$contact_link->apple_app_link}}" label="Apple App Link" name="apple_app_link"
                               placeholder="Enter apple app link ..."/>

                <x-forms.button class="align-items-center mt-3">Create</x-forms.button>
            </x-forms.form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
