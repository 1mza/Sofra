@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/clients')}}">Clients</a></li>
            <li class="breadcrumb-item active"><a href="{{route('clients.show',$client->id)}}">{{$client->name}}</a></li>

        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-cyan"><i class="nav-icon fas fa-address-card"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Show clients page</span>
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
                client Info
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
                <tr>
                    <th scope="col">#ID</th>
                    <td>{{$client->id}}</td>
                </tr>
                <tr>
                    <th scope="col">Name</th>
                    <td>{{$client->name}}</td>
                </tr>
                <tr>
                    <th scope="col">Email</th>
                    <td>{{$client->email}}</td>
                </tr>
                <tr>
                    <th scope="col">Phone</th>
                    <td>{{$client->phone}}</td>
                </tr>
                <tr>
                    <th scope="col">City</th>
                    <td>{{$client->city->name}}</td>
                </tr>
                <tr>
                    <th scope="col">Neighbourhood</th>
                    <td>{{$client->neighbourhood->name}}</td>
                </tr>
                <tr>
                    <th scope="col">Created_at (Date/Time)</th>
                    <td>{{$client->created_at}}</td>
                </tr>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
