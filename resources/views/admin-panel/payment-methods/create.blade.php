@extends('layouts.admin-app')
@inject('paymentMethods','App\Models\PaymentMethod')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/payment-methods')}}">Payment Methods</a></li>
            <li class="breadcrumb-item active"><a href="{{route('payment-methods.create')}}">Create</a></li>

        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-blue-800"><i class="nav-icon fab fa-cc-visa"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Create payment method page</span>
                <span class="info-box-number">{{$paymentMethods->count()}}</span>
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
                Create form
            </h3>

        </div>
        <div class="card-body">
            <x-forms.form class="d-flex flex-column" method="post" action="{{route('payment-methods.store')}}">
                @csrf
                @method('POST')
                <x-forms.select name="seller_id" label="Select Restaurant">
                    <option disabled selected>Select Restaurant</option>
                    @foreach($sellers as $seller)
                        <option value="{{$seller->id}}">{{$seller->restaurant_name}}</option>
                    @endforeach
                </x-forms.select>
                <x-forms.input label="Name" type="text" name="name"
                               placeholder="Enter payment method name..."/>
                <x-forms.label name="description" label="Description"/>
                <textarea class="rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full" name="description"
                          placeholder="Enter description"></textarea>
                <x-forms.button class="align-items-center mt-3">Create</x-forms.button>
            </x-forms.form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
