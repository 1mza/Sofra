@extends('layouts.admin-app')
@inject('sellers','App\Models\Seller')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/sellers')}}">Sellers</a></li>
            <li class="breadcrumb-item active"><a href="{{route('sellers.create')}}">Create</a></li>

        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-green"><i class="nav-icon fas fa-address-card"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Create cities page</span>
                <span class="info-box-number">{{$sellers->count()}}</span>
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
            <x-forms.form class="d-flex flex-column" method="post" action="{{route('sellers.store')}}">
                @csrf
                @method('POST')
                <x-forms.input value="{{old('restaurant_name')}}" label="Restaurant Name" type="text" name="restaurant_name"
                               placeholder="Enter seller name..."/>
                <x-forms.input value="{{old('email')}}" label="Email" type="email" name="email" placeholder="Enter email"/>
                <x-forms.input value="{{old('phone')}}" label="Phone" type="text" name="phone" placeholder="Enter phone..."/>
                <x-forms.input label="Image" type="file" name="image"/>
                <x-forms.input label="Password" type="password" name="password"/>
                <x-forms.input label="Password Confirmation" type="password" name="password_confirmation"/>
                <x-forms.select label="City" name="city_id">
                    <option selected disabled>Select City</option>
                    @foreach($cities as $city)
                        <option {{old('city_id')==$city->id ? 'selected':''}} value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                </x-forms.select>
                <x-forms.select label="Neighbourhood" name="neighbourhood_id">
                    <option selected disabled>Select Neighbourhood</option>
                    @foreach($neighbourhoods as $neighbourhood)
                        <option {{old('neighbourhood_id')==$neighbourhood->id ? 'selected':''}} value="{{$neighbourhood->id}}">{{$neighbourhood->name}}</option>
                    @endforeach
                </x-forms.select>
                <label>Category</label>
                @foreach($categories as $category)
                    <x-forms.checkbox
                            label="{{ $category->name }}"
                            name="category_id"
                            value="{{ $category->id }}"
                            :checked="in_array($category->id, old('category_id', []))"
                    />
                @endforeach
                <x-forms.select label="Status" name="status">
                    <option selected disabled>Select Status</option>
                    <option {{old('status')=='open' ? 'selected':''}} value="open">open</option>
                    <option {{old('status')=='closed' ? 'selected':''}} value="closed">closed</option>
                </x-forms.select>
                <x-forms.input value="{{old('minimum_charge')}}" label="Minimum Charge" type="number" name="minimum_charge"
                               placeholder="Enter minimum charge (LE)..."/>
                <x-forms.input value="{{old('delivery_fees')}}" label="Delivery Fees" type="number" name="delivery_fees"
                               placeholder="Enter delivery fees (LE)..."/>
                <x-forms.input value="{{old('delivery_phone')}}" label="Delivery Phone" type="text" name="delivery_phone"
                               placeholder="Enter delivery phone..."/>
                <x-forms.input value="{{old('delivery_whatsapp')}}" label="Delivery Whatsapp" type="text" name="delivery_whatsapp"
                               placeholder="Enter delivery whatsapp..."/>
                <x-forms.button class="align-items-center mt-3">Create</x-forms.button>
            </x-forms.form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
