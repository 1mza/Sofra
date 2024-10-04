@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/sellers')}}">Sellers</a></li>
            <li class="breadcrumb-item active"><a href="{{route('sellers.show',$seller->id)}}">{{$seller->restaurant_name}}</a></li>

        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-green"><i class="nav-icon fas fa-address-card"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Show sellers page</span>
                <span class="info-box-number">{{$seller->restaurant_name}}</span>
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
                seller Info
            </h3>

        </div>
        <div class="card-body">
            {{--            @include('flash::message')--}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
            @elseif(session('danger'))
                <div class="alert alert-danger">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table">
                <tr>
                    <th scope="col">#ID</th>
                    <td>{{$seller->id}}</td>
                </tr>
                <tr>
                    <th scope="col">Restaurant Name</th>
                    <td>{{$seller->restaurant_name}}</td>
                </tr>
                <tr>
                    <th scope="col">Email</th>
                    <td>{{$seller->email}}</td>
                </tr>
                <tr>
                    <th scope="col">Phone</th>
                    <td>{{$seller->phone}}</td>
                </tr>
                <tr>
                    <th scope="col">Status</th>
                    <td>{{$seller->status}}</td>
                </tr>
                <tr>
                    <th scope="col">Image</th>
                    <td><img style="height: 350px;width: 400px;" src="{{asset($seller->image)}}" alt="seller image"></td>
                </tr>
                <tr>
                    <th scope="col">City</th>
                    <td>{{$seller->city->name}}</td>
                </tr>
                <tr>
                    <th scope="col">Neighbourhood</th>
                    <td>{{$seller->neighbourhood->name}}</td>
                </tr>
                <tr>
                    <th scope="col">Delivery Phone</th>
                    <td>{{$seller->delivery_phone}}</td>
                </tr>
                <tr>
                    <th scope="col">Delivery Whatsapp</th>
                    <td>{{$seller->delivery_whatsapp}}</td>
                </tr>
                <tr>
                    <th scope="col">Delivery Fees</th>
                    <td>{{$seller->delivery_fees}} LE</td>
                </tr>
                <tr>
                    <th scope="col">Minimum Charge</th>
                    <td>{{$seller->minimum_charge}} LE</td>
                </tr>
                <tr>
                    <th scope="col">Restaurant Sales (LE)</th>
                    <td>{{$seller->restaurant_sales}} LE</td>
                </tr>
                <tr>
                    <th scope="col">App Commissions (LE)</th>
                    <td>{{$seller->app_commissions}} LE</td>
                </tr>
                <tr>
                    <th scope="col">Created_at (Date/Time)</th>
                    <td>{{$seller->created_at}}</td>
                </tr>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
