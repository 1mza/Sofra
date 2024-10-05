@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/roles')}}">Roles</a></li>
        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-red-100"><i class="nav-icon fab fa-critical-role"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Roles</span>
                <span class="info-box-number">{{$roles->count()}}</span>
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
                <h3 class="card-title mb-0 col-4">
                    List of Roles
                </h3>

                <!-- Search Form -->
                <x-forms.form class=" col-4 d-flex align-items-center" action="{{route('roles.index')}}">
                    <div class="input-group">
                        <input class="form-control border rounded-start" value="{{request('search')}}" type="text"
                               name="search" placeholder="Search for a role...">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </x-forms.form>
                @can('create role')
                    <div class="col-4 text-end">
                        <a href="{{route('roles.create')}}" class="ml-auto btn btn-primary ms-3">
                            Add New Role
                        </a>
                    </div>
                @endcan
            </div>
            {{--            @include('flash::message')--}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card-body p-0">
                <div class="table-responsive">
                    @can('list roles')
                        <table class="table table-bordered table-hover w-100 m-0">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Guard</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <th>{{$role->id}}</th>
                                    <td>{{$role->name}}</td>
                                    <td>{{$role->guard_name}}</td>
                                    <td>
                                        @can('update role')
                                            <a href="{{route('roles.edit',$role)}}"
                                               class="btn btn-warning">Edit</a>
                                        @endcan
                                        @can('delete role')
                                            <form action="{{route('roles.destroy',$role)}}" method="post"
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
                    {{$roles->links()}}
                </div>
            </div>
        </div>
    </div>

    <!-- /.card -->

@endsection
