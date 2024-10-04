@extends('layouts.admin-app')
@inject('commissions','App\Models\Commission')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/commissions')}}">Commissions</a></li>
            <li class="breadcrumb-item active"><a href="{{route('commissions.create')}}">Create</a></li>

        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-yellow"><i class="nav-icon fa fa-credit-card"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Create commissions page</span>
                <span class="info-box-number">{{$commissions->count()}}</span>
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
            <x-forms.form class="d-flex flex-column" method="post" action="{{route('commissions.store')}}">
                @csrf
                @method('POST')
                <x-forms.select name="seller_id" label="Select Restaurant">
                    <option disabled selected>Select Restaurant</option>
                    @foreach($sellers as $seller)
                        <option {{old('seller_id') == $seller->id ?'selected':''}} value="{{$seller->id}}">{{$seller->restaurant_name}}</option>
                    @endforeach
                </x-forms.select>
                <x-forms.input label="Amount Paid" type="number" name="amount_paid" step="0.5"
                               placeholder="Enter paid money (LE)..."/>
                <x-forms.input label="Note" type="text" name="note"
                               placeholder="Enter note..."/>
                <x-forms.button class="align-items-center mt-3">Create</x-forms.button>
            </x-forms.form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
