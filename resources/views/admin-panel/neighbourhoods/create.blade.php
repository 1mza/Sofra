@extends('layouts.admin-app')
@inject('neighbourhoods','App\Models\Neighbourhood')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/neighbourhoods')}}">Neighbourhoods</a></li>
            <li class="breadcrumb-item active"><a href="{{route('neighbourhoods.create')}}">Create</a></li>

        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-blue"><i class="nav-icon fa fa-map-marker"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Create neighbourhoods page</span>
                <span class="info-box-number">{{$neighbourhoods->count()}}</span>
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
                Create form
            </h3>

        </div>
        <div class="card-body">
            <x-forms.form class="d-flex flex-column" method="post" action="{{route('neighbourhoods.store')}}">
                @csrf
                @method('POST')
                <x-forms.select name="city_id" label="City">
                    <option selected disabled>Select City</option>
                    @foreach($cities as $city)
                        <option value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                </x-forms.select>
                <x-forms.input label="Neighbourhood"  type="text" name="name"
                               placeholder="Enter neighbourhood name..." />
                <x-forms.button class="align-items-center mt-3">Create</x-forms.button>
            </x-forms.form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
