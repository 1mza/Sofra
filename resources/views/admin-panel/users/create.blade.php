@extends('layouts.admin-app')
@inject('users','App\Models\Client')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/users')}}">Users</a></li>
            <li class="breadcrumb-item active"><a href="{{route('users.create')}}">Create</a></li>

        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-secondary"><i class="nav-icon far fa-address-card"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Create clients page</span>
                <span class="info-box-number">{{$users->count()}}</span>
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
            <x-forms.form class="d-flex flex-column" method="post" action="{{route('users.store')}}">
                @csrf
                @method('POST')
                <x-forms.input value="{{old('name')}}" label="Name" type="text" name="name"
                               placeholder="Enter username..."/>
                <x-forms.input value="{{old('email')}}" label="Email" type="email" name="email"
                               placeholder="Enter email"/>
                <x-forms.input label="Password" type="password" name="password"/>
                <x-forms.input label="Password Confirmation" type="password" name="password_confirmation"/>
                <x-forms.checkbox id="selectAllCheckbox" name="role" label="Check All" onClick="toggle(this)"/>
                @foreach($roles as $role)
                    <x-forms.checkbox
                            :checked="request('role')"
                            class="checkboxes" name="role[]" label="{{$role->name}}"
                            value="{{$role->name}}"/>
                @endforeach
                <x-forms.button class="align-items-center mt-3">Create</x-forms.button>
            </x-forms.form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <script>
        document.getElementById('selectAllCheckbox')
            .addEventListener('change', function () {
                let checkboxes =
                    document.querySelectorAll('.checkboxes');
                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = this.checked;
                }, this);
            });
    </script>
@endsection
