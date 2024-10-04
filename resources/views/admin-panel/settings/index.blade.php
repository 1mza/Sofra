@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/settings')}}">Settings</a></li>
        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-gradient-white"><i class="nav-icon fa fa-cogs"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Settings</span>
                <span class="info-box-number">{{$settings->count()}}</span>
            </div>
        </div>
    </div>
@endsection

@section('small_title')

@endsection
@section('content')

    <!-- Default box -->
    <div class="container-fluid p-0">
        <div class="card p-0 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="card-header d-flex justify-content-between align-items-center col-12">
                <!-- Title -->
                <h3 class="card-title mb-0 col-8">
                    List of Settings
                </h3>

                <!-- Search Form -->
                <div class="col-4 mx-auto ml-auto d-flex justify-content-center">
                    <x-forms.form enctype="multipart/form-data" class="d-flex w-100"
                                  action="{{route('settings.index')}}">
                        <div class="input-group w-100">
                            <input class="form-control border rounded-start" value="{{request('search')}}" type="text"
                                   name="search" placeholder="Search for a text...">
                            <button class="btn btn-outline-primary" type="submit">Search</button>
                        </div>
                    </x-forms.form>
                </div>
            </div>

            {{--            @include('flash::message')--}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card-body p-0">
                <div class="table-responsive">
                    {{--                    @can('cities-lists')--}}
                    <table class="table table-bordered table-hover w-100 m-0">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">About App</th>
                            <th scope="col">Commission Text</th>
                            <th scope="col">Date/Time</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($settings as $setting)
                            <tr>
                                <th>{{$loop->iteration}}</th>
                                <td>{{$setting->about_app}}</td>
                                <td>{{$setting->commission_text}}</td>
                                <td>{{$setting->updated_at}}</td>
                                <td>
                                    {{--                                        @can('cities-edit')--}}
                                    <a class="btn btn-warning" href="{{route('settings.edit',$setting)}}">Edit</a>
                                    {{--                                        @endcan--}}

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{--                    @endcan--}}
                </div>
            </div>
        </div>
    </div>

    <!-- /.card -->

@endsection
