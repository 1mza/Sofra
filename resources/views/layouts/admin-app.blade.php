<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blood Bank</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Google Font: Source Sans Pro -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('adminlte/css/adminlte.min.css')}}">
    <style>
        /* Adjust the image size and positioning when the sidebar is collapsed */
        .sidebar-mini.sidebar-collapse .user-panel .image img {
            width: auto;  /* Maintain aspect ratio */
            height: 40px;  /* Set a fixed height */
            max-width: 100%;  /* Ensure the image doesn't overflow */
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        /* Center the user info and badges when the sidebar is collapsed */
        .sidebar-mini.sidebar-collapse .user-panel .info {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding-top: 10px;  /* Add some padding if necessary */
        }


    </style>
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{url('admin/homeAdmin')}}" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{url('admin/contact-us')}}" class="nav-link">Contact US</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                   aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <form action="{{route('logout')}}" method="POST">
                    @csrf
                    <button class="nav-link" data-widget="logout" role="button">
                        <i class="">Logout</i>
                    </button>
                </form>
            </li>

        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="../../index3.html" class="brand-link">
            <img src="{{asset('adminlte/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{asset('adminlte/img/user2-160x160.jpg')}}" class="img-circle elevation-2"
                         alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{auth()->user()->name}}</a>
                    @foreach(auth()->user()->roles->pluck('name') as $role)
                        <label class="badge badge-light mx-1">{{$role}}</label>
                    @endforeach
                </div>
            </div>



            <!-- Sidebar Menu -->
            <nav class="mt-2">

                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li>
                        <!-- SidebarSearch Form -->
                        <div class="form-inline">
                            <div class="input-group" data-widget="sidebar-search">
                                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                                       aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-sidebar">
                                        <i class="fas fa-search fa-fw"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class=" nav-item">
                        <a href="#" class="{{request()->is('admin/posts') || request()->is('admin/categories') ? 'bg-gray-900 text-white' : null}} nav-link">
                            <i class="  nav-icon fa fa-table"></i>
                            <p>
                                Posts
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="{{request()->is('admin/posts') ? 'bg-gray-900 text-white' : null}}nav-item">
                                <a href="{{url('admin/posts')}}" class="nav-link">
                                    <i class="far fa-clipboard nav-icon"></i>
                                    <p>Posts</p>
                                </a>
                            </li>
                            <li>
                            <li class="{{request()->is('categories') ? 'bg-gray-900 text-white' : null}}nav-item">
                                <a href="{{url('admin/categories')}}" class="nav-link">
                                    <i class="nav-icon fa fa-list-alt"></i>
                                    <p>Categories</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                    <li class="{{request()->is('admin/governorates') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{url('admin/governorates')}}" class="nav-link">
                            <i class="nav-icon fa fa-city"></i>
                            <p>Governorates</p>
                        </a>
                    </li>
                    <li>
                    <li class="{{request()->is('admin/cities') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{url('admin/cities')}}" class="nav-link">
                            <i class="nav-icon fa fa-map-marker"></i>
                            <p>Cities</p>
                        </a>
                    </li>
                    <li>
                    <li class="{{request()->is('admin/donation-requests') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{url('admin/donation-requests')}}" class="nav-link">
                            <i class="nav-icon fa fa-paper-plane"></i>
                            <p>Donation Requests</p>
                        </a>
                    </li>
                    <li class="{{request()->is('admin/clients') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{url('admin/clients')}}" class="nav-link">
                            <i class="nav-icon fa fa-server"></i>
                            <p>Clients</p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="{{request()->is('admin/users') || request()->is('admin/roles') || request()->is('admin/permissions') ? 'bg-gray-900 text-white' : null}} nav-link">
                            <i class="nav-icon fa fa-list"></i>
                            <p>Users</p>
                            <i class="right fas fa-angle-left"></i>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="{{request()->is('admin/users') ? 'bg-gray-900 text-white' : null}}nav-item">
                                <a href="{{url('admin/users')}}" class="nav-link">
                                    <i class="nav-icon fa fa-users "></i>
                                    <p>Users Informations</p>
                                </a>
                            </li>
                            <li class="{{request()->is('admin/roles') ? 'bg-gray-900 text-white' : null}}nav-item">
                                <a href="{{url('admin/roles')}}" class="nav-link">
                                    <i class="nav-icon far fa-user "></i>
                                    <p>Roles</p>
                                </a>
                            </li>
                            <li class="{{request()->is('admin/permissions') ? 'bg-gray-900 text-white' : null}}nav-item">
                                <a href="{{url('admin/permissions')}}" class="nav-link">
                                    <i class=" nav-icon far fa-address-book"></i>
                                    <p>Permissions</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{request()->is('admin/contacts') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{url('admin/contacts')}}" class="nav-link">
                            <i class="nav-icon fas fa-envelope"></i>
                            <p>Contacts</p>
                        </a>
                    </li>
                    <li class="{{request()->is('admin/contact-us') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{url('admin/contact-us')}}" class="nav-link">
                            <i class="nav-icon fas fa-phone"></i>
                            <p>Contact Us</p>
                        </a>
                    </li>
                    <li class="{{request()->is('admin/settings') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{url('admin/settings')}}" class="nav-link">
                            <i class="nav-icon fa fa-cog"></i>
                            <p>Settings</p>
                        </a>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            @yield('page_title')
                            <small>@yield('small_title')</small>
                        </h1>
                    </div>
                    @yield('breadcrumb')
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">

            @yield('content')

        </section>
    </div>


    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.2.0
        </div>
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('adminlte/js/demo.js')}}"></script>
</body>
</html>
