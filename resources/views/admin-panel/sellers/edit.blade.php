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
                <span class="info-box-text">Edit sellers page</span>
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
                Edit form
            </h3>

        </div>
        <div class="card-body">
            <x-forms.form class="d-flex flex-column" method="post" action="{{route('sellers.update',$seller)}}">
                @csrf
                @method('PATCH')
                <x-forms.input value="{{$seller->restaurant_name}}" label="Restaurant Name" type="text" name="restaurant_name"
                               placeholder="Enter seller name..."/>
                <x-forms.input value="{{$seller->email}}" label="Email" type="email" name="email" placeholder="Enter email"/>
                <x-forms.input value="{{$seller->phone}}" label="Phone" type="text" name="phone" placeholder="Enter phone..."/>
                <img style="width: 900px;height: 400px" src="{{asset($seller->image)}}">
                <x-forms.input label="Image" type="file" name="image"/>
                <label>Password</label>
                <input class="rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full" type="password" name="password" >
                <x-forms.error name='password'></x-forms.error>

                <label>Password Confirmation</label>
                <input class="rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full" type="password" name="password_confirmation" >
                <x-forms.error name='password_confirmation'></x-forms.error>

                <x-forms.select label="City" name="city_id">
                    <option selected disabled>Select City</option>
                    @foreach($cities as $city)
                        <option {{$seller->city_id==$city->id ? 'selected':''}} value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                </x-forms.select>
                <x-forms.select label="Neighbourhood" name="neighbourhood_id">
                    <option selected disabled>Select Neighbourhood</option>
                    @foreach($neighbourhoods as $neighbourhood)
                        <option {{$seller->neighbourhood_id==$neighbourhood->id ? 'selected':''}} value="{{$neighbourhood->id}}">{{$neighbourhood->name}}</option>
                    @endforeach
                </x-forms.select>
                <label>Category</label>
                @foreach($categories as $category)
                    <x-forms.checkbox
                            label="{{ $category->name }}"
                            name="category_id"
                            value="{{ $category->id }}"
                            :checked="in_array($category->id, $seller->categories->pluck('id')->toArray())"
                    />
                @endforeach
                <x-forms.select label="Status" name="status">
                    <option selected disabled>Select Status</option>
                    <option {{$seller->status=='open' ? 'selected':''}} value="open">open</option>
                    <option {{$seller->status=='closed' ? 'selected':''}} value="closed">closed</option>
                </x-forms.select>
                <x-forms.input value="{{$seller->minimum_charge}}" label="Minimum Charge" type="number" name="minimum_charge"
                               placeholder="Enter minimum charge (LE)..."/>
                <x-forms.input value="{{$seller->delivery_fees}}" label="Delivery Fees" type="number" name="delivery_fees"
                               placeholder="Enter delivery fees (LE)..."/>
                <x-forms.input value="{{$seller->delivery_phone}}" label="Delivery Phone" type="text" name="delivery_phone"
                               placeholder="Enter delivery phone..."/>
                <x-forms.input value="{{$seller->delivery_whatsapp}}" label="Delivery Whatsapp" type="text" name="delivery_whatsapp"
                               placeholder="Enter delivery whatsapp..."/>
                <x-forms.button class="align-items-center mt-3">Save</x-forms.button>
            </x-forms.form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
