@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/products')}}">Products</a></li>
        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-amber-800"><i class="nav-icon fab fa-product-hunt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Products</span>
                <span class="info-box-number">{{$products->count()}}</span>
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
                    List of Products
                </h3>

                <!-- Search Form -->
                <x-forms.form class=" col-4 d-flex align-items-center" action="{{route('products.index')}}">
                    <div class="input-group">
                        <input class="form-control border rounded-start" value="{{request('search')}}" type="text"
                               name="search" placeholder="Search for a product...">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </x-forms.form>
                @can('create product')
                    <div class="col-4 text-end">
                        <a href="{{route('products.create')}}" class="ml-auto btn btn-primary ms-3">
                            Add New Product
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
                    @can('list products')
                        <table class="table table-bordered table-hover w-100 m-0">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Seller Name (restaurant)</th>
                                <th scope="col">Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Brief Description</th>
                                <th scope="col">Price</th>
                                <th scope="col">Offer Price</th>
                                <th scope="col">Preparation Time</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <th>{{$product->id}}</th>
                                    <td>
                                        <a href="{{route('sellers.show',$product->seller)}}">{{$product->seller->restaurant_name}}</a>
                                    </td>
                                    <td>{{$product->name}}</td>
                                    <td><img src="{{asset($product->image)}}" style="width: 800px;height: 200px"></td>
                                    <td>{{$product->brief_description}}</td>
                                    <td>{{$product->price.' LE'}} </td>
                                    <td>{{$product->offer_price !==null ?$product->offer_price.' LE' : 'No Offer'}} </td>
                                    <td>{{$product->preparation_time}}</td>
                                    <td>{{$product->created_at}}</td>
                                    <td>
                                        @can('update product')
                                            <a href="{{route('products.edit',$product)}}"
                                               class="btn btn-warning">Edit</a>
                                        @endcan
                                        @can('delete product')
                                            <form action="{{route('products.destroy',$product)}}" method="post"
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
                    {{$products->links()}}
                </div>
            </div>
        </div>
    </div>

    <!-- /.card -->

@endsection
