@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/permissions')}}">Permissions</a></li>
            <li class="breadcrumb-item active">{{$permission->name}}</li>
        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-red-100"><i class="nav-icon fas fa-eye-slash"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Edit permissions page</span>
                <span class="info-box-number">{{$permission->name}}</span>
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
            <x-forms.form class="d-flex flex-column" method="post" action="{{route('permissions.update',$permission)}}">
                @csrf
                @method('PATCH')
                <x-forms.input value="{{$permission->name}}" label="Name" type="text" name="name"
                               placeholder="Enter permission name..."/>
                <x-forms.label name="role_id" label="Select Roles"/>
                <x-forms.checkbox id="selectAllCheckbox" name="role" label="Check All" onClick="toggle(this)"/>
                @foreach($roles as $role)
                    <x-forms.checkbox
                            :checked="$permission->roles->contains($role->id)"
                            class="checkboxes" name="role[]" label="{{$role->name}}"
                            value="{{$role->name}}"/>
                @endforeach

                <x-forms.button class="align-items-center mt-3">Save</x-forms.button>
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
