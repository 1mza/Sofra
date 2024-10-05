@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/offers')}}">Offers</a></li>
        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-indigo"><i class="nav-icon fa fa-gift"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Offers</span>
                <span class="info-box-number">{{$offers->count()}}</span>
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
                    List of Offers
                </h3>

                <!-- Search Form -->
                <div class="col-4 mx-auto ml-auto d-flex justify-content-center">
                    <x-forms.form enctype="multipart/form-data" class="d-flex w-100" action="{{route('offers.index')}}">
                        <div class="input-group w-100">
                            <input class="form-control border rounded-start" value="{{request('search')}}" type="text"
                                   name="search" placeholder="Search for an offer...">
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
                    @can('list offers')
                        <table class="table table-bordered table-hover w-100 m-0">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Seller (restaurant name)</th>
                                <th scope="col">Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Brief Description</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($offers as $offer)
                                <tr>
                                    <th>{{$loop->iteration}}</th>
                                    <td><a class="row-link"
                                           href="
                                       {{route('sellers.show',$offer->seller->id)}}
                                       ">{{$offer->seller->restaurant_name}}</a></td>
                                    <td>{{$offer->name}}</td>
                                    <td><img style="height: 200px;width: 900px;" src="{{asset($offer->image)}}"
                                             alt="offer image"></td>
                                    <td>{{$offer->brief_description}}</td>
                                    <td>{{$offer->start_date}}</td>
                                    <td>{{$offer->end_date}}</td>


                                    <td>
                                        @can('delete offer')
                                            <form action="{{route('offers.destroy',$offer)}}" method="post"
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
                    {{$offers->links()}}
                </div>
            </div>
        </div>
    </div>

    <!-- /.card -->

@endsection
