@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/neighbourhoods')}}">Neighbourhoods</a></li>
            <li class="breadcrumb-item active"><a href="{{route('neighbourhoods.show',$neighbourhood->id)}}">{{$neighbourhood->name}}</a></li>

        </ol>
    </div>
@endsection
@section('page_title')
    show neighbourhoods page
@endsection

@section('small_title')
@endsection
@section('content')
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="nav-icon fa fa-map-marker"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Neighbourhood</span>
                <span class="info-box-number">{{$neighbourhood->name}}</span>
            </div>
        </div>
    </div>
    <!-- Default box -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                Neighbourhood Info
            </h3>

        </div>
        <div class="card-body">
            {{--            @include('flash::message')--}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
            @elseif(session('danger'))
                <div class="alert alert-danger">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">City</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">{{$neighbourhood->id}}</th>
                    <td>{{$neighbourhood->name}}</td>
                    <td>{{$neighbourhood->city->name}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
