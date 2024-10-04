@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/neighbourhoods')}}">Neighbourhoods</a></li>
        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-blue"><i class="nav-icon fa fa-map-marker"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Neighbourhoods</span>
                <span class="info-box-number">{{$neighbourhoods->count()}}</span>
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
                    List of Neighbourhoods
                </h3>

                <!-- Search Form -->
                <x-forms.form class=" col-4 d-flex align-items-center" action="{{route('neighbourhoods.index')}}">
                    <div class="input-group">
                        <input class="form-control border rounded-start" value="{{request('search')}}" type="text"
                               name="search" placeholder="Search for a neighbourhood...">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </x-forms.form>
                {{--                @can('neighbourhoods-create')--}}
                <div class="col-4 text-end">
                    <a href="{{route('neighbourhoods.create')}}" class="ml-auto btn btn-primary ms-3">
                        Add New Neighbourhood
                    </a>
                </div>
                {{--                @endcan--}}
            </div>
            {{--            @include('flash::message')--}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif(session('danger'))
                <div class="alert alert-danger">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card-body p-0">
                <div class="table-responsive">
                    {{--                    @can('neighbourhoods-lists')--}}
                    <table class="table table-bordered table-hover w-100 m-0">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">City</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($neighbourhoods as $neighbourhood)
                            <tr>
                                <th>{{$loop->iteration}}</th>
                                <td><a class="row-link"
                                       href="{{route('neighbourhoods.show',$neighbourhood)}}">{{$neighbourhood->name}}</a>
                                </td>
                                <td><a class="row-link"
                                       href="{{route('cities.show',$neighbourhood->city->id)}}">{{$neighbourhood->city->name}}</a>
                                </td>

                                <td>
                                    {{--                                        @can('neighbourhoods-edit')--}}
                                    <a href="{{route('neighbourhoods.edit',$neighbourhood)}}"
                                       class="btn btn-warning">Edit</a>
                                    {{--                                        @endcan--}}
                                    {{--                                        @can('neighbourhoods-delete')--}}
                                    <form action="{{route('neighbourhoods.destroy',$neighbourhood)}}" method="post"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')"
                                                class="btn btn-danger">Delete
                                        </button>
                                    </form>
                                    {{--                                        @endcan--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{--                    @endcan--}}
                    {{$neighbourhoods->links()}}
                </div>
            </div>
        </div>
    </div>

    <!-- /.card -->

@endsection
