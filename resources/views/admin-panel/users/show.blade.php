@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/users')}}">Users</a></li>
            <li class="breadcrumb-item active"><a href="{{route('users.show',$user->id)}}">{{$user->name}}</a></li>

        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-secondary"><i class="nav-icon fas fa-address-card"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Show users page</span>
                <span class="info-box-number">{{$user->name}}</span>
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
                User Info
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
                    <td>{{$user->id}}</td>
                </tr>
                <tr>
                    <th scope="col">Name</th>
                    <td>{{$user->name}}</td>
                </tr>
                <tr>
                    <th scope="col">Email</th>
                    <td>{{$user->email}}</td>
                </tr>

                <tr>
                    <th scope="col">Created_at (Date/Time)</th>
                    <td>{{$user->created_at}}</td>
                </tr>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
