@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/payment-methods')}}">Payment Methods</a></li>
            <li class="breadcrumb-item active"><a href="{{route('payment-methods.show',$paymentMethod->id)}}">{{$paymentMethod->name}}</a></li>

        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-blue-800"><i class="nav-icon fab fa-cc-visa"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Show payment methods page</span>
                <span class="info-box-number">{{$paymentMethod->name}}</span>
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
                Payment Method Info
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
                    <td scope="col">{{$paymentMethod->id}}</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">Name</th>
                    <td>{{$paymentMethod->name}}</td>
                </tr>
                <tr>
                    <th scope="row">Seller Name (restaurant)</th>
                    <td>{{$paymentMethod->seller->restaurant_name}}</td>
                </tr>
                <tr>
                    <th scope="row">Seller Name (restaurant)</th>
                    <td><img src="{{asset($paymentMethod->seller->image)}}"></td>
                </tr>
                <tr>
                    <th scope="row">Payment method description</th>
                    <td>{{$paymentMethod->description}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
