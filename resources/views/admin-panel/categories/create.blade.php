@extends('layouts.admin-app')
@inject('categories','App\Models\Category')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/categories')}}">Categories</a></li>
            <li class="breadcrumb-item active"><a href="{{route('categories.create')}}">Create</a></li>

        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-black"><i class="nav-icon fa fa-list-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Create categories page</span>
                <span class="info-box-number">{{$categories->count()}}</span>
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
            <x-forms.form class="d-flex flex-column" method="post" action="{{route('categories.store')}}">
                @csrf
                @method('POST')
                <x-forms.input label="Category" type="text" name="name"
                               placeholder="Enter category name..." />
                <x-forms.button class="align-items-center mt-3">Create</x-forms.button>
            </x-forms.form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
