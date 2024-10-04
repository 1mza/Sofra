@extends('layouts.admin-app')
@inject('cities','App\Models\City')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/products')}}">Products</a></li>
            <li class="breadcrumb-item active"><a href="{{route('products.show',$product->id)}}">{{$product->name}}</a></li>
        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-amber-800"><i class="nav-icon fab fa-product-hunt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Edit products page</span>
                <span class="info-box-number">{{$product->name}}</span>
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
                Edit form
            </h3>

        </div>
        <div class="card-body">
            <x-forms.form class="d-flex flex-column" method="post" action="{{route('products.update',$product)}}">
                @csrf
                @method('PATCH')
                <x-forms.select name="seller_id" label="Select Restaurant">
                    <option disabled selected>Select Restaurant</option>
                    @foreach($sellers as $seller)
                        <option {{$product->seller_id==$seller->id? 'selected' :''}} value="{{$seller->id}}">{{$seller->restaurant_name}}</option>
                    @endforeach
                </x-forms.select>
                <x-forms.input value="{{$product->name}}" label="Name" type="text" name="name"
                               placeholder="Enter product name..."/>
                <img style="height: 500px;width: 900px;" src="{{asset($product->image)}}" alt="offer image">
                <x-forms.input label="Image" type="file" name="image"/>
                <x-forms.label label="Brief Description" name="brief_description"/>
                <textarea class="rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full"
                          name="brief_description"
                          placeholder="Enter brief description">{{$product->brief_description}}</textarea>
                <x-forms.input value="{{$product->price}}" label="Price" type="number" step="0.1" name="price"
                               placeholder="Enter price in EGP..."/>
                <x-forms.input value="{{$product->offer_price}}" label="Offer Price" type="number" step="0.1" name="offer_price"
                               placeholder="Enter offer price in EGP if exist..."/>
                <x-forms.input value="{{$product->preparation_time}}" label="Preparation Time" type="text" name="preparation_time"
                               placeholder="ex: 15 minutes..."/>
                <x-forms.button class="align-items-center mt-3">Save</x-forms.button>
            </x-forms.form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
