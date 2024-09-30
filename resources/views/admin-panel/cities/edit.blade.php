@extends('layouts.appAdmin')
{{--@inject('clients','App\Models\Client')--}}
@inject('cities','App\Models\City')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('homeAdmin')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('cities')}}">Cities</a></li>
            <li class="breadcrumb-item active"><a href="{{route('cities.show',$city->id)}}">{{$city->name}}</a></li>
            @dd($donationRequest->id);

        </ol>
    </div>
@endsection
@section('page_title')
    Edit cities page
@endsection

@section('small_title')
@endsection
@section('content')
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="nav-icon fa fa-map-marker"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">City</span>
                <span class="info-box-number">{{$city->name}}</span>
            </div>
        </div>
    </div>
    <!-- Default box -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                Edit form
            </h3>

        </div>
        <div class="card-body">

            {{html()->modelForm($cities,'PUT')->class('form')->route('cities.update',$city->id)->open()}}
            @include('partials.validation_errors')
            @include('cities.form')
            {{html()->closeModelForm()}}
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
