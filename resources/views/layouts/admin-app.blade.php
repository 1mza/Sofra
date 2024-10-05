<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sofra admin panel</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/font-awesome.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('adminlte/css/adminlte.min.css')}}">
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
                <a href="{{url('admin-panel/home')}}" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{url('admin-panel/contact-links')}}" class="nav-link">Contact US Links</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar SearchSearch -->
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
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="break-normal justify-center user-panel d-flex">
                <div class="info w-full text-white flex flex-col items-center justify-center mt-2 rounded-md hover:text-white hover:bg-gray-600 transition duration-150">
                    <a href="profile" class="text-center d-block">
                        {{ auth()->user()->name }}
                        <small class="d-block">{{ auth()->user()->email }}</small>
                        @foreach(auth()->user()->roles->pluck('name') as $role)
                            <label class="break-normal badge badge-light role-badge" title="{{ $role }}">{{ $role }}</label>
                        @endforeach

                    </a>
                </div>
            </div>





            <!-- Sidebar Menu -->
            <nav class="mt-2">

                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li>
                        @livewire('search')
                    </li>
                    <li class=" nav-item">
                        <a href="#"
                           class="{{request()->is('admin-panel/clients') || request()->is('admin-panel/sellers') ? 'bg-gray-900 text-white' : null}} nav-link">
                            <i class="  nav-icon fa fa-table"></i>
                            <p>
                                Customers
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="{{request()->is('admin-panel/sellers') ? 'bg-gray-900 text-white' : null}}nav-item">
                                <a href="{{url('admin-panel/sellers')}}" class="nav-link">
                                    <i class="fas fa-address-card nav-icon"></i>
                                    <p>Sellers</p>
                                </a>
                            </li>
                            <li>
                            <li class="{{request()->is('clients') ? 'bg-gray-900 text-white' : null}}nav-item">
                                <a href="{{url('admin-panel/clients')}}" class="nav-link">
                                    <i class="nav-icon far fa-address-card"></i>
                                    <p>Clients</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>

                    <li>
                    <li class="{{request()->is('admin-panel/cities') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{url('admin-panel/cities')}}" class="nav-link">
                            <i class="nav-icon fa fa-city"></i>
                            <p>Cities</p>
                        </a>
                    </li>
                    <li class="{{request()->is('admin-panel/neighbourhoods') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{url('admin-panel/neighbourhoods')}}" class="nav-link">
                            <i class="nav-icon fa fa-map-marker"></i>
                            <p>Neighbourhoods</p>
                        </a>
                    </li>
                    <li class="{{request()->is('admin-panel/categories') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{url('admin-panel/categories')}}" class="nav-link">
                            <i class="nav-icon fa fa-list-alt"></i>
                            <p>Categories</p>
                        </a>
                    </li>
                    <li class="{{request()->is('admin-panel/products') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{url('admin-panel/products')}}" class="nav-link">
                            <i class="nav-icon fab fa-product-hunt"></i>
                            <p>Products</p>
                        </a>
                    </li>
                    <li class="{{request()->is('admin-panel/orders') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{url('admin-panel/orders')}}" class="nav-link">
                            <i class="nav-icon fa fa-cart-plus"></i>
                            <p>Orders</p>
                        </a>
                    </li>
                    <li class="{{request()->is('admin-panel/offers') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{url('admin-panel/offers')}}" class="nav-link">
                            <i class="nav-icon fa fa-gift"></i>
                            <p>Offers</p>
                        </a>
                    </li>
                    <li class="{{request()->is('admin-panel/commissions') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{url('admin-panel/commissions')}}" class="nav-link">
                            <i class="nav-icon 	fa fa-credit-card"></i>
                            <p>Commissions</p>
                        </a>
                    </li>
                    <li class="{{request()->is('admin-panel/payment-methods') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{url('admin-panel/payment-methods')}}" class="nav-link">
                            <i class="nav-icon 	fab fa-cc-visa"></i>
                            <p>Payment Methods</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#"
                           class="{{request()->is('admin-panel/users') || request()->is('admin-panel/roles') || request()->is('admin-panel/permissions') ? 'bg-gray-900 text-white' : null}} nav-link">
                            <i class="nav-icon fa fa-list"></i>
                            <p>Users</p>
                            <i class="right fas fa-angle-left"></i>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="{{request()->is('admin-panel/users') ? 'bg-gray-900 text-white' : null}}nav-item">
                                <a href="{{url('admin-panel/users')}}" class="nav-link">
                                    <i class="nav-icon fa fa-users "></i>
                                    <p>Users Information's</p>
                                </a>
                            </li>
                            <li class="{{request()->is('admin-panel/roles') ? 'bg-gray-900 text-white' : null}}nav-item">
                                <a href="{{url('admin-panel/roles')}}" class="nav-link">
                                    <i class="nav-icon fab fa-critical-role "></i>
                                    <p>Roles</p>
                                </a>
                            </li>
                            <li class="{{request()->is('admin-panel/permissions') ? 'bg-gray-900 text-white' : null}}nav-item">
                                <a href="{{url('admin-panel/permissions')}}" class="nav-link">
                                    <i class=" nav-icon fas fa-eye-slash"></i>
                                    <p>Permissions</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{request()->is('admin-panel/contacts') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{url('admin-panel/contacts')}}" class="nav-link">
                            <i class="nav-icon fas fa-envelope"></i>
                            <p>Contacts</p>
                        </a>
                    </li>
                    <li class="{{request()->is('admin-panel/contact-links') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{url('admin-panel/contact-links')}}" class="nav-link">
                            <i class="nav-icon fas fa-phone"></i>
                            <p>Contact Links</p>
                        </a>
                    </li>
                    <li class="{{request()->is('admin-panel/profile') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{route('profile.edit')}}" class="nav-link">
                            <i class="nav-icon fa fa-user"></i>
                            <p>Profile</p>
                        </a>
                    </li>
                    <li class="{{request()->is('admin-panel/settings') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <a href="{{url('admin-panel/settings')}}" class="nav-link">
                            <i class="nav-icon fa fa-cogs"></i>
                            <p>Settings</p>
                        </a>
                    </li>
                    <li class="{{request()->is('/logout') ? 'bg-gray-900 text-white' : null}}nav-item">
                        <form method="POST" id="logout" action="{{ route('logout') }}">
                            @csrf
                            <a onclick="document.getElementById('logout').submit()" class="nav-link">
                                <i class="nav-icon fa fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </form>
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
