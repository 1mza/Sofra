@extends('layouts.admin-app')
@inject('products','App\Models\Product')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/settings')}}">Settings</a></li>
            <li class="breadcrumb-item active"><a href="{{route('settings.create')}}">Create</a></li>

        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-gradient-white"><i class="nav-icon fa fa-cogs"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Create settings page</span>
{{--                <span class="info-box-number">{{$products->count()}}</span>--}}
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
            <x-forms.form class="d-flex flex-column" method="post" action="{{route('settings.store')}}">
                @csrf
                @method('POST')
                <x-forms.label name="about_app" label="About App" />
                <textarea class="rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full" name="about_app"
                          placeholder="Enter About app">{{ request('about_app') }}</textarea>

                <x-forms.label name="commission_text" label="Commission Text" />
                <textarea class="rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full" name="commission_text"
                          placeholder="Enter Commission text">{{ request('commission_text') }}</textarea>
                <x-forms.button class="align-items-center mt-3">Create</x-forms.button>
            </x-forms.form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
