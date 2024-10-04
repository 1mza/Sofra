@extends('layouts.admin-app')
@inject('contactLinks','App\Models\ContactLink')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/contact-links')}}">Contact Links</a></li>
            <li class="breadcrumb-item active"><a href="{{route('contact-links.create')}}">Create</a></li>

        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-indigo"><i class="nav-icon fa fa-phone"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Create contact-links page</span>
                <span class="info-box-number">{{$contactLinks->count()}}</span>
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
                Create form
            </h3>

        </div>
        <div class="card-body">
            <x-forms.form class="d-flex flex-column" method="post" action="{{route('contact-links.store')}}">
                @csrf
                @method('POST')
                <x-forms.input value="{{request('phone')}}" label="Phone" name="phone"
                               placeholder="Enter phone ..."/>

                <x-forms.input value="{{request('email')}}" type="email" label="Email" name="email"
                               placeholder="Enter email  ..."/>

                <x-forms.input value="{{request('whatsapp_link')}}" label="Whatsapp Link" name="whatsapp_link"
                               placeholder="Enter whatsapp link ..."/>

                <x-forms.input value="{{request('x_link')}}" label="X Link" name="x_link"
                               placeholder="Enter x link ..."/>

                <x-forms.input value="{{request('linkedin_link')}}" label="LinkedIn Link" name="linkedin_link"
                               placeholder="Enter linkedin link ..."/>

                <x-forms.input value="{{request('facebook_link')}}" label="Facebook Link" name="facebook_link"
                               placeholder="Enter facebook link ..."/>

                <x-forms.input value="{{request('youtube_link')}}" label="Youtube Link" name="youtube_link"
                               placeholder="Enter youtube link ..."/>

                <x-forms.input value="{{request('instagram_link')}}" label="Instagram Link" name="instagram_link"
                               placeholder="Enter instagram link ..."/>

                <x-forms.input value="{{request('google_link')}}" label="Google Link" name="google_link"
                               placeholder="Enter google link ..."/>

                <x-forms.input value="{{request('android_app_link')}}" label="Android App Link" name="android_app_link"
                               placeholder="Enter android app link ..."/>

                <x-forms.input value="{{request('apple_app_link')}}" label="Apple App Link" name="apple_app_link"
                               placeholder="Enter apple app link ..."/>

                <x-forms.button class="align-items-center mt-3">Create</x-forms.button>
            </x-forms.form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
