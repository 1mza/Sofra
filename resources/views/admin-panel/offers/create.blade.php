@extends('layouts.admin-app')
@inject('cities','App\Models\City')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/cities')}}">Cities</a></li>
            <li class="breadcrumb-item active"><a href="{{route('cities.create')}}">Create</a></li>

        </ol>
    </div>
@endsection
@section('page_title')
    Create cities page
@endsection

@section('small_title')
@endsection
@section('content')
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="nav-icon fa fa-map-marker"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Cities</span>
                <span class="info-box-number">{{$cities->count()}}</span>
            </div>
        </div>
    </div>
    <!-- Default box -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                Create form
            </h3>

        </div>
        <div class="card-body">
            <x-forms.form class="d-flex flex-column" method="post" action="{{route('cities.store')}}">
                @csrf
                @method('POST')
                <x-forms.input label="City"  type="text" name="name"
                               placeholder="Enter city name..." />
                <x-forms.button class="align-items-center mt-3">Create</x-forms.button>
            </x-forms.form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
