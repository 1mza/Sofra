@extends('layouts.admin-app')
{{--@inject('clients','App\Models\Client')--}}
{{--@inject('donationRequests','App\Models\DonationRequest')--}}
{{--@inject('governorates','App\Models\Governorate')--}}

@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
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
                        <span class="info-box-text">Clients</span>
                        <span class="info-box-number">{{$clients}}</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-dark">
                <span class="info-box-icon bg-info"><i class="fa fa-server"></i></span>
                <div class="info-box-content">
                    <a href="sellers">
                        <span class="info-box-text">Sellers</span>
                        <span class="info-box-number">{{$sellers}}</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-dark">
                <span class="info-box-icon bg-red"><i class="fa fa-city"></i></span>
                <div class="info-box-content">
                    <a href="cities">
                        <span class="info-box-text">Cities</span>
                        <span class="info-box-number">{{$cities}}</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-dark">
                <span class="info-box-icon bg-blue"><i class="fa fa-map-marker"></i></span>
                <div class="info-box-content">
                    <a href="neighbourhoods">
                        <span class="info-box-text">Neighbourhoods</span>
                        <span class="info-box-number">{{$neighbourhoods}}</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-dark">
                <span class="info-box-icon bg-green"><i class="fa fa-paper-plane"></i></span>
                <div class="info-box-content">
                    <a href="orders">
                        <span class="info-box-text">Orders</span>
                        <span class="info-box-number">{{$orders->count()}}</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-dark">
                <span class="info-box-icon bg-yellow"><i class="far fa-clipboard"></i></span>
                <div class="info-box-content">
                    <a href="commissions">
                        <span class="info-box-text">Commissions</span>
                        <span class="info-box-number">{{$commissions}}</span>
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
                        <span class="info-box-number">{{$categories}}</span>
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
                        <span class="info-box-number">{{$users}}</span>
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
                        <span class="info-box-number">{{$contacts}}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- First Column -->
        <div class="col-md-6">
            <p class="text-center">
                <strong>Goal Completion</strong>
            </p>

            <div class="progress-group">
                Accepted Orders
                <span class="float-end"><b>{{$acceptedOrders}}</b>/{{$orders->count()}}</span>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-primary"
                         style="width: {{$acceptedOrders/$orders->count() * 100}}%"></div>
                </div>
            </div>
            <!-- /.progress-group -->

            <div class="progress-group">
                Refused Orders
                <span class="float-end"><b>{{$refusedOrders}}</b>/{{$orders->count()}}</span>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-danger" style="width: {{$refusedOrders/$orders->count() * 100}}%"></div>
                </div>
            </div>
            <!-- /.progress-group -->

            <div class="progress-group">
                <span class="progress-text">Delivered Orders</span>
                <span class="float-end"><b>{{$deliveredOrders}}</b>/{{$orders->count()}}</span>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-success"
                         style="width: {{$deliveredOrders/$orders->count() * 100}}%"></div>
                </div>
            </div>
            <!-- /.progress-group -->

            <div class="progress-group">
                Declined Orders
                <span class="float-end"><b>{{$declinedOrders}}</b>/{{$orders->count()}}</span>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-warning"
                         style="width: {{$declinedOrders/$orders->count() * 100}}%"></div>
                </div>
            </div>
            <!-- /.progress-group -->
            @php
                $latestSellersCount = $sellersInfo->where('created_at','>=',now()->subDays(30));
            @endphp
                    <!-- Latest Members Section -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Latest Sellers (restaurants)</h3>

                    <div class="card-tools">
                        <span class="badge bg-danger">{{$latestSellersCount->count()}} New Members</span>
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-lte-dismiss="card-remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <ul class="users-list clearfix">
                        @foreach($latestSellersCount as $seller)
                            <li>
                                <div class="w-100">
                                    <img src="{{asset($seller->image)}}" style="width: 150px;height: 115px"
                                         alt="User Image">
                                </div>
                                <div>
                                    <a class="users-list-name" href="#">{{$seller->restaurant_name}}</a>
                                    <span class="users-list-date">{{date($seller->created_at->format('y-m-d'))}}</span>
                                </div>
                            </li>
                        @endforeach


                    </ul>
                    <!-- /.users-list -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-center">
                    <a href="sellers">View All Sellers</a>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-md-6 -->

        <!-- Second Column -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recently Added Products</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-lte-dismiss="card-remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card ps-2 pe-2">
                        @foreach($latestBoughtProducts as $product)
                            <li class="item">
                                <div class="product-img">
                                    <img src="{{asset($product->image)}}" alt="Product Image" class="img-size-50">
                                </div>
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">{{$product->name}}
                                        <span class="badge bg-warning float-end">${{$product->price}}</span></a>
                                    <span class="product-description">
                                {{$product->brief_description}}
                            </span>
                                </div>
                            </li>
                        @endforeach
                        <!-- /.item -->
                    </ul>
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-center">
                    <a href="products" class="uppercase">View All Products</a>
                </div>
                <!-- /.card-footer -->
            </div>
        </div>
        <!-- /.col-md-6 -->
    </div>

    <!-- /.col -->
@endsection
