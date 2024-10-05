@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/permissions')}}">Permissions</a></li>
        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-red-100"><i class="nav-icon fas fa-eye-slash	"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Permissions</span>
                <span class="info-box-number">{{$permissions->count()}}</span>
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
                    List of Permissions
                </h3>

                <!-- Search Form -->
                <x-forms.form class=" col-4 d-flex align-items-center" action="{{route('permissions.index')}}">
                    <div class="input-group">
                        <input class="form-control border rounded-start" value="{{request('search')}}" type="text"
                               name="search" placeholder="Search for a permissions...">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </x-forms.form>
                @can('create permission')
                    <div class="col-4 text-end">
                        <a href="{{route('permissions.create')}}" class="ml-auto btn btn-primary ms-3">
                            Add New Permissions
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
                    @can('list permissions')
                        <table class="table table-bordered table-hover w-100 m-0">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Guard</th>
                                <th scope="col">Role</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <th>{{$permission->id}}</th>
                                    <td>{{$permission->name}}</td>
                                    <td>{{$permission->guard_name}}</td>
                                    <td>
                                        @foreach($permission->roles as $role)
                                            <span>{{$role->name}}</span>{{!$loop->last ? ', ' : ''}}
                                        @endforeach
                                    </td>
                                    <td>
                                        @can('update permission')
                                            <a href="{{route('permissions.edit',$permission)}}"
                                               class="btn btn-warning">Edit</a>
                                        @endcan
                                        @can('delete permission')
                                            <form action="{{route('permissions.destroy',$permission)}}" method="post"
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
                    {{$permissions->links()}}
                </div>
            </div>
        </div>
    </div>

    <!-- /.card -->

@endsection
