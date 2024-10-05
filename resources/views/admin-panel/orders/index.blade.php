@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/orders')}}">Orders</a></li>
        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon text-white w-25 bg-rose-950"><i class="nav-icon fa fa-cart-plus"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Orders</span>
                <span class="info-box-number">{{$orders->count()}}</span>
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
                    List of Orders
                </h3>

                <!-- Search Form -->
                <x-forms.form class=" col-4 d-flex align-items-center" action="{{route('orders.index')}}">
                    <div class="input-group">
                        <input class="form-control border rounded-start" value="{{request('search')}}" type="text"
                               name="search" placeholder="Search for an order...">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </x-forms.form>
                <div class="col-4 text-end">
                    <x-forms.button onclick="window.print()" name="Print" label="Print">Print</x-forms.button>
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
                    @can('list orders')
                        <table class="table table-bordered table-hover w-100 m-0">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Client</th>
                                <th scope="col">Seller (restaurant)</th>
                                <th scope="col">notes</th>
                                <th scope="col">Delivery Address</th>
                                <th scope="col">Order Status</th>
                                <th scope="col">Payment Method</th>
                                <th scope="col">Total</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <th><a class="row-link"
                                           href="{{route('orders.show',$order)}}">{{$loop->iteration}}</a></th>
                                    <td><a class="row-link"
                                           href="{{route('clients.show',$order->client)}}">{{$order->client->name}}</a>
                                    </td>
                                    <td><a class="row-link"
                                           href="{{route('sellers.show',$order->seller)}}">{{$order->seller->restaurant_name}}</a>
                                    </td>
                                    <td>{{$order->notes}}</td>
                                    <td>{{$order->delivery_address}}</td>
                                    <td>{{$order->order_status}}</td>
                                    <td><a class="row-link"
                                           href="{{route('payment-methods.show',$order->paymentMethod)}}">{{$order->paymentMethod->name}}</a>
                                    </td>
                                    <td>{{$order->total}} LE</td>
                                    <td>{{$order->created_at}}</td>
                                    <td>
                                        @can('delete order')
                                            <form action="{{route('orders.destroy',$order)}}" method="post"
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
                    {{$orders->links()}}
                </div>
            </div>
        </div>
    </div>

    <!-- /.card -->

@endsection
