@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/commissions')}}">Commissions</a></li>
        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-yellow"><i class="nav-icon fa fa-credit-card"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Commissions</span>
                <span class="info-box-number">{{$commissions->count()}}</span>
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
                    List of Commissions
                </h3>

                <!-- Search Form -->
                <x-forms.form class=" col-4 d-flex align-items-center" action="{{route('commissions.index')}}">
                    <div class="input-group">
                        <input class="form-control border rounded-start" value="{{request('search')}}" type="text"
                               name="search" placeholder="Search for a commission...">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </x-forms.form>
                {{--                @can('cities-create')--}}
                <div class="col-4 text-end">
                    <a href="{{route('commissions.create')}}" class="ml-auto btn btn-primary ms-3">
                        Add New commission
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
                    {{--                    @can('cities-lists')--}}
                    <table class="table table-bordered table-hover w-100 m-0">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Seller (restaurant name)</th>
                            <th scope="col">Amount Paid</th>
                            <th scope="col">Note</th>
                            <th scope="col">Remaining Amount</th>
                            <th scope="col">Created (Date/Time)</th>
                            <th scope="col">Updated (Date/Time)</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($commissions as $commission)
                            <tr>
                                <th>{{$loop->iteration}}</th>
                                <td><a class="row-link"
                                       href="
{{--                                       {{route('sellers.show',$commission->seller->id)}}--}}
                                       ">{{$commission->seller->restaurant_name}}</a>
                                </td>
                                <td>{{$commission->amount_paid}}</td>
                                <td>{{$commission->note}}</td>
                                <td>{{$commission->remaining_amount}}</td>
                                <td>{{$commission->created_at}}</td>
                                <td>{{$commission->updated_at}}</td>
                                <td>
                                    {{--                                        @can('cities-edit')--}}
                                    <a href="{{route('commissions.edit',$commission)}}"
                                       class="btn btn-warning">Edit</a>
                                    {{--                                        @endcan--}}
                                    {{--                                        @can('cities-delete')--}}
                                    <form action="{{route('commissions.destroy',$commission)}}" method="post"
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
                    {{$commissions->links()}}
                </div>
            </div>
        </div>
    </div>

    <!-- /.card -->

@endsection
