@extends('layouts.appAdmin')
@inject('clients','App\Models\Client')
@inject('donationRequests','App\Models\DonationRequest')
@inject('governorates','App\Models\Governorate')
@use('App\Models\City','City')
@use('App\Models\Post','Post')
@use('App\Models\Category','Category')
@use('App\Models\User','User')
@use('App\Models\Contact','Contact')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin/homeAdmin')}}">Home /</a></li>
        </ol>
    </div>
@endsection
@section('page_title')
    Dashboard
@endsection
@section('small_title')
    Statistics
@endsection
@section('content')
    <div class="row">

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-dark">
                <span class="info-box-icon bg-info"><i class="fa fa-server"></i></span>
                <div class="info-box-content">
                    <a href="clients">
                    <span class="info-box-text" >Clients</span>
                    <span class="info-box-number">{{$clients->count()}}</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-dark">
                <span class="info-box-icon bg-blue"><i class="fa fa-city"></i></span>
                <div class="info-box-content">
                    <a href="governorates">
                    <span class="info-box-text">Governorates</span>
                    <span class="info-box-number">{{$governorates->count()}}</span>
                        </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-dark">
                <span class="info-box-icon bg-red"><i class="fa fa-map-marker"></i></span>
                <div class="info-box-content">
                    <a href="cities">
                    <span class="info-box-text">Cities</span>
                    <span class="info-box-number">{{City::count()}}</span>
                        </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-dark">
                <span class="info-box-icon bg-green"><i class="fa fa-paper-plane"></i></span>
                <div class="info-box-content">
                    <a href="donation-requests">
                    <span class="info-box-text">Donation Requests</span>
                    <span class="info-box-number">{{$donationRequests->count()}}</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-dark">
                <span class="info-box-icon bg-yellow"><i class="far fa-clipboard"></i></span>
                <div class="info-box-content">
                    <a href="posts">
                    <span class="info-box-text">Posts</span>
                    <span class="info-box-number">{{Post::count()}}</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-dark">
                <span class="info-box-icon bg-black"><i class="fa fa-list-alt"></i></span>
                <div class="info-box-content">
                    <a href="categories">
                    <span class="info-box-text">Categories</span>
                    <span class="info-box-number">{{Category::count()}}</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-dark">
                <span class="info-box-icon bg-secondary"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <a href="users">
                    <span class="info-box-text">Users</span>
                    <span class="info-box-number">{{User::count()}}</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-dark">
                <span class="info-box-icon bg-light"><i class="fas fa-envelope"></i></span>
                <div class="info-box-content">
                    <a href="contacts">
                    <span class="info-box-text">Contacts</span>
                    <span class="info-box-number">{{Contact::count()}}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>


@endsection
