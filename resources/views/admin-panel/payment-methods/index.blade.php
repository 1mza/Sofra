@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/payment-methods')}}">Payment Methods</a></li>
        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-blue-800"><i class="nav-icon fab fa-cc-visa"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Payment Methods</span>
                <span class="info-box-number">{{$paymentMethods->count()}}</span>
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
                    List of Payment Methods
                </h3>

                <!-- Search Form -->
                <x-forms.form class=" col-4 d-flex align-items-center" action="{{route('payment-methods.index')}}">
                    <div class="input-group">
                        <input class="form-control border rounded-start" value="{{request('search')}}" type="text"
                               name="search" placeholder="Search for a payment method...">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </x-forms.form>
                @can('create payment method')
                    <div class="col-4 text-end">
                        <a href="{{route('payment-methods.create')}}" class="ml-auto btn btn-primary ms-3">
                            Add New Payment Method
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
                    @can('list payment methods')
                        <table class="table table-bordered table-hover w-100 m-0">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Seller Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($paymentMethods as $paymentMethod)
                                <tr>
                                    <th>{{$loop->iteration}}</th>
                                    <td>
                                        <a href="{{route('sellers.show',$paymentMethod->seller)}}">{{$paymentMethod->seller->restaurant_name}}</a>
                                    </td>
                                    <td><img src="{{asset($paymentMethod->seller->image)}}" alt="seller image"></td>
                                    <td>
                                        <a href="{{route('payment-methods.show',$paymentMethod)}}">{{$paymentMethod->name}}</a>
                                    </td>
                                    <td>{{$paymentMethod->description}}</td>
                                    <td>
                                        @can('update payment method')
                                            <a href="{{route('payment-methods.edit',$paymentMethod)}}"
                                               class="btn btn-warning">Edit</a>
                                        @endcan
                                        @can('delete payment method')
                                            <form action="{{route('payment-methods.destroy',$paymentMethod)}}"
                                                  method="post"
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
                    {{$paymentMethods->links()}}
                </div>
            </div>
        </div>
    </div>

    <!-- /.card -->

@endsection
