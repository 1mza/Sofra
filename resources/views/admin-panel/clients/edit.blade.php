@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/clients')}}">Clients</a></li>
            <li class="breadcrumb-item active"><a href="{{route('clients.show',$client->id)}}">{{$client->restaurant_name}}</a></li>
        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-cyan"><i class="nav-icon far fa-address-card"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Edit clients page</span>
                <span class="info-box-number">{{$client->name}}</span>
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
            <x-forms.form class="d-flex flex-column" method="post" action="{{route('clients.update',$client)}}">
                @csrf
                @method('PATCH')
                <x-forms.input value="{{$client->name}}" label="Name" type="text" name="name"
                               placeholder="Enter client name..."/>
                <x-forms.input value="{{$client->email}}" label="Email" type="email" name="email" placeholder="Enter email"/>
                <x-forms.input value="{{$client->phone}}" label="Phone" type="text" name="phone" placeholder="Enter phone..."/>
                @livewire('password-checker')
                <x-forms.select label="City" name="city_id">
                    <option selected disabled>Select City</option>
                    @foreach($cities as $city)
                        <option {{$client->city_id==$city->id ? 'selected':''}} value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                </x-forms.select>
                <x-forms.select label="Neighbourhood" name="neighbourhood_id">
                    <option selected disabled>Select Neighbourhood</option>
                    @foreach($neighbourhoods as $neighbourhood)
                        <option {{$client->neighbourhood_id==$neighbourhood->id ? 'selected':''}} value="{{$neighbourhood->id}}">{{$neighbourhood->name}}</option>
                    @endforeach
                </x-forms.select>
                <x-forms.button class="align-items-center mt-3">Save</x-forms.button>
            </x-forms.form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
