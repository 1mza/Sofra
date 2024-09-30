@extends('layouts.appAdmin')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('homeAdmin')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('cities')}}">Cities</a></li>
        </ol>
    </div>
@endsection
@section('page_title')
    Cities
@endsection

@section('small_title')
    <br>
    Index-Overview
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
    <div class="container-fluid p-0">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    List of Cities
                </h3>
                @can('cities-create')
                    <a href="{{route('cities.create')}}" class="btn btn-primary">
                        Add New City
                    </a>
                @endcan
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    @can('cities-lists')
                        <table class="table table-bordered table-hover w-100 m-0">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Governorate</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cities as $city)
                                <tr>
                                    <th>{{$loop->iteration}}</th>
                                    <th><a class="row-link"
                                           href="{{route('cities.show',$city->id)}}">{{$city->name}}</a></th>
                                    <th><a class="row-link"
                                           href="{{route('governorates.show',$city->governorate_id)}}">{{$city->governorate->name}}</a>
                                    </th>
                                    <td>
                                        @can('cities-edit')
                                            <a href="{{route('cities.edit',$city->id)}}"
                                               class="btn btn-warning">Edit</a>
                                        @endcan
                                        @can('cities-delete')
                                            <form action="{{route('cities.destroy',$city->id)}}" method="post"
                                                  style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure?')"
                                                        class="btn btn-danger">Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <!-- /.card -->

@endsection
