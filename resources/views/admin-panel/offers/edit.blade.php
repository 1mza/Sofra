@extends('layouts.admin-app')
@inject('offers','App\Models\Offer')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/offers')}}">Offers</a></li>
            <li class="breadcrumb-item active"><a href="{{route('offers.show',$offer->id)}}">{{$offer->id}}</a></li>
        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-blue"><i class="nav-icon fa fa-map-marker"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Edit offers page</span>
                <span class="info-box-number">Offers {{$offers->count()}}</span>
            </div>
        </div>
    </div>@endsection

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
            <x-forms.form class="d-flex flex-column" method="post" action="{{route('offers.update',$offer)}}">
                @csrf
                @method('PATCH')
                <x-forms.select name="seller_id" label="Restaurant Name">
                    <option>Select Seller</option>
                    @foreach($sellers as $seller)
                        <option {{$seller->id == $offer->seller->id ? 'selected' : ''}} value="{{$seller->id}}">{{$seller->restaurant_name}}</option>
                    @endforeach
                </x-forms.select>
                <x-forms.input value="{{$offer->name}}" label="Name" type="text" name="name"
                               placeholder="Enter name..."/>
                <x-forms.input value="{{$offer->brief_description}}" label="Image" type="file" name="image"/>
                <img class=" flex-auto justify-content-center" style="height: 300px;width: 500px;" src="{{asset($offer->image)}}" alt="offer image">

                <x-forms.label name="brief_description" label="Brief Description" />
                <textarea class="rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full"
                          name="brief_description"
                          placeholder="Write a brief one less than 3 lines...">{{ old('brief_description', $offer->brief_description ?? '') }}</textarea>

                <x-forms.input value="{{$offer->start_date}}" label="Start Date" type="date" name="start_date"/>
                <x-forms.input value="{{$offer->end_date}}" label="End Date" type="date" name="end_date"/>
                <x-forms.button class="align-items-center mt-3">Create</x-forms.button>
            </x-forms.form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
