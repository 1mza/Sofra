@extends('layouts.admin-app')
@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin-panel/home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin-panel/contact-links')}}">Contact Links</a></li>
        </ol>
    </div>
@endsection
@section('page_title')
    <div class="w-75">
        <div class="info-box">
            <span class="info-box-icon w-25 bg-indigo"><i class="nav-icon fa fa-phone"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Contact Links</span>
                <span class="info-box-number">{{$contact_links->count()}}</span>
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
            <div class="card-header d-flex justify-content-between align-items-center w-full ">
                <!-- Title -->
                <h3 class="card-title mb-0 ">
                    List Of Contact Links
                </h3>
                @if($contact_links->count() == 0)
                    @can('create contact link')
                        <div class=" text-end">
                            <a href="{{route('contact-links.create')}}" class="ml-auto btn btn-primary ms-3">
                                Add New Contact Links
                            </a>
                        </div>
                    @endcan
                @endif
            </div>


            {{--            @include('flash::message')--}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card-body p-0">
                <div class="table-responsive">
                    @can('list contact links')
                        <table class="table table-bordered table-hover w-100 m-0">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Email</th>
                                <th scope="col">Whatsapp Link</th>
                                <th scope="col">X Link</th>
                                <th scope="col">LinkedIn Link</th>
                                <th scope="col">Facebook Link</th>
                                <th scope="col">Youtube Link</th>
                                <th scope="col">Instagram Link</th>
                                <th scope="col">Google Link</th>
                                <th scope="col">Android App Link</th>
                                <th scope="col">Apple App Link</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contact_links as $contact_link)
                                <tr>
                                    <th>{{$loop->iteration}}</th>
                                    <td>{{$contact_link->phone}}</a></td>
                                    <td>{{$contact_link->email}}</a></td>
                                    <td>{{$contact_link->whatsapp_link}}</a></td>
                                    <td>{{$contact_link->x_link}}</a></td>
                                    <td>{{$contact_link->linkedin_link}}</a></td>
                                    <td>{{$contact_link->facebook_link}}</a></td>
                                    <td>{{$contact_link->youtube_link}}</a></td>
                                    <td>{{$contact_link->instagram_link}}</a></td>
                                    <td>{{$contact_link->google_link}}</a></td>
                                    <td>{{$contact_link->android_app_link}}</a></td>
                                    <td>{{$contact_link->apple_app_link}}</a></td>

                                    <td>
                                        @can('update contact link')
                                            <a href="{{ route('contact-links.edit', $contact_link) }}"
                                               class="btn btn-warning">Edit</a>

                                        @endcan
                                        @can('delete contact link')
                                            <form action="{{route('contact-links.destroy',$contact_link)}}"
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
                </div>
            </div>
        </div>
    </div>

    <!-- /.card -->

@endsection
