@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/orders')}}">Orders</a></li>
            <li class="breadcrumb-item active"><a href="{{route('orders.show',$order->id)}}">{{$order->id}}</a></li>

        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-rose-950"><i class="nav-icon fa fa-cart-plus"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Show orders page</span>
                <span class="info-box-number">{{$order->id}}</span>
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
                Order Info
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
                <thead>
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">{{$order->id}}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">Client Name</th>
                    <td class="text-bold">{{$order->client->name}}</td>
                </tr>
                <tr>
                    <th scope="row">Seller Name (restaurant)</th>
                    <td class="text-bold">{{$order->seller->restaurant_name}}</td>
                </tr>
                <tr>
                    <th scope="row">Notes</th>
                    <td class="text-bold">{{$order->notes}}</td>
                </tr>
                <tr>
                    <th scope="row">Delivery Address</th>
                    <td class="text-bold">{{$order->delivery_address}}</td>
                </tr>
                <tr>
                    <th scope="row">Order Status</th>
                    <td class="text-bold">{{$order->order_status}}</td>
                </tr>
                <tr>
                    <th scope="row">Payment Method</th>
                    <td class="text-bold">{{$order->paymentMethod->name}}</td>
                </tr>
                <tr>
                    <th scope="row">Total</th>
                    <td class="text-bold">{{$order->total}} LE</td>
                </tr>
                <tr>
                    <th scope="row">Created At</th>
                    <td class="text-bold">{{$order->created_at}}</td>
                </tr>
                @foreach($order->products as $key => $product)
                    <tr>
                        <th scope="row">Product {{$key}} Name</th>
                        <td class="text-bold">{{$product->name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Product {{$key}} Image</th>
                        <td class="text-bold"><img style="height: 300px;width: 300px;" src="{{asset($product->image)}}"></td>
                    </tr>
                    <tr>
                        <th scope="row">Product {{$key}} Special Note</th>
                        <td class="text-bold">{{$product->pivot->special_note}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Product {{$key}} Quantity</th>
                        <td class="text-bold">{{$product->pivot->quantity}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Product {{$key}} Price</th>
                        <td class="text-bold">{{$product->price}} * {{$product->pivot->quantity}} = {{$product->pivot->price}} LE</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
