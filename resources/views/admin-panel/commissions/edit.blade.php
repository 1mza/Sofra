@extends('layouts.admin-app')
@inject('cities','App\Models\City')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/commissions')}}">Commissions</a></li>
            <li class="breadcrumb-item active">{{$commission->id}}</li>
        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-yellow"><i class="nav-icon fa fa-credit-card"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Edit commissions page</span>
                <span class="info-box-number">{{$commission->seller->restaurant_name}}</span>
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
                Edit form
            </h3>

        </div>
        <div class="card-body">
            <x-forms.form class="d-flex flex-column" method="post" action="{{route('commissions.update',$commission)}}">
                @csrf
                @method('PATCH')
                <x-forms.select name="seller_id" label="Select Restaurant">
                    <option disabled selected>Select Restaurant</option>
                    @foreach($sellers as $seller)
                        <option {{$commission->seller->id == $seller->id ?'selected':''}} value="{{$seller->id}}">{{$seller->restaurant_name}}</option>
                    @endforeach
                </x-forms.select>
                <x-forms.input value="{{$commission->amount_paid}}" label="Amount Paid" type="number" name="amount_paid"
                               step="0.5"
                               placeholder="Enter paid money (LE)..."/>
                <x-forms.input value="{{$commission->note}}" label="Note" type="text" name="note"
                               placeholder="Enter note..."/>
                <x-forms.input value="{{$commission->remaining_amount}}" label="Remaining Amount" type="number" name="remaining_amount"
                               step="0.5"
                               placeholder="Enter remaining money (LE)..."/>
                <x-forms.button class="align-items-center mt-3">Save</x-forms.button>
            </x-forms.form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
