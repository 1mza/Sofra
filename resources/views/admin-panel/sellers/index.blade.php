@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/sellers')}}">Sellers</a></li>
        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-green"><i class="nav-icon fas fa-address-card"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Sellers</span>
                <span class="info-box-number">{{$sellers->count()}}</span>
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
                    List of Sellers
                </h3>

                <!-- Search Form -->
                <x-forms.form class=" col-4 d-flex align-items-center" action="{{route('sellers.index')}}">
                    <div class="input-group">
                        <input class="form-control border rounded-start" value="{{request('search')}}" type="text"
                               name="search" placeholder="Search for a restaurant...">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </x-forms.form>
                {{--                @can('cities-create')--}}
                <div class="col-4 text-end">
                    <a href="{{route('sellers.create')}}" class="ml-auto btn btn-primary ms-3">
                        Add New Seller
                    </a>
                </div>
                {{--                @endcan--}}
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
                            <th scope="col">Restaurant Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Image</th>
                            <th scope="col">Phone</th>
                            <th scope="col">City</th>
                            <th scope="col">Neighbourhood</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sellers as $seller)
                            <tr>
                                <th>{{$loop->iteration}}</th>
                                <td><a class="row-link"
                                       href="{{route('sellers.show',$seller)}}">{{$seller->restaurant_name}}</a></td>
                                <td>{{$seller->email}}</td>
                                <td><img style="height: 200px;width: 200px;" alt="seller image" src="{{asset($seller->image)}}"></td>
                                <td>{{$seller->phone}}</td>
                                <td>{{$seller->city->name}}</td>
                                <td>{{$seller->neighbourhood->name}}</td>
                                <td>{{$seller->status}}</td>
                                <td>
                                    {{--                                        @can('cities-edit')--}}
                                    <a href="{{route('sellers.edit',$seller)}}"
                                       class="btn btn-warning">Edit</a>
                                    {{--                                        @endcan--}}
                                    {{--                                        @can('cities-delete')--}}
                                    <form action="{{route('sellers.destroy',$seller)}}" method="post"
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
                    {{$sellers->links()}}
                </div>
            </div>
        </div>
    </div>

    <!-- /.card -->

@endsection
