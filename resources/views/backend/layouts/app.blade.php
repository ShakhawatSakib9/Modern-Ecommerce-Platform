<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Innoflexia') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AdminLTE 3 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @stack('styles')

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #fdfcfb 0%, #e2d1c3 100%);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            --hover-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            --sidebar-width: 250px;
            --font-family: 'Inter', sans-serif;
        }

        body {
            font-family: var(--font-family) !important;
            background-color: #f4f7f6 !important;
            color: #2d3748;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Dark Mode Overrides */
        body.dark-mode {
            background-color: #1a202c !important;
            color: #e2e8f0;
        }

        .dark-mode .card {
            background-color: #2d3748 !important;
            color: #e2e8f0 !important;
        }

        .dark-mode .card-header,
        .dark-mode .bg-white {
            background-color: #2d3748 !important;
            border-bottom-color: #4a5568 !important;
        }

        .dark-mode .card-title,
        .dark-mode h1,
        .dark-mode h2,
        .dark-mode h3,
        .dark-mode h4,
        .dark-mode h5,
        .dark-mode h6 {
            color: #e2e8f0 !important;
        }

        .dark-mode .table {
            color: #e2e8f0 !important;
        }

        .dark-mode .bg-light {
            background-color: #1a202c !important;
        }

        .dark-mode .text-dark {
            color: #e2e8f0 !important;
        }

        .dark-mode .form-control {
            background-color: #1a202c !important;
            border-color: #4a5568 !important;
            color: #e2e8f0 !important;
        }

        .dark-mode .main-footer {
            background-color: #2d3748 !important;
            border-top-color: #4a5568 !important;
            color: #cbd5e0 !important;
        }

        .dark-mode .main-header,
        .dark-mode .navbar-white {
            background-color: #2d3748 !important;
            border-bottom-color: #4a5568 !important;
        }

        .dark-mode .main-sidebar,
        .dark-mode .sidebar-dark-primary {
            background-color: #1a202c !important;
        }

        .dark-mode .nav-sidebar .nav-link {
            color: #cbd5e0 !important;
        }

        .dark-mode .nav-sidebar .nav-link.active {
            background-color: #4a5568 !important;
            color: #ffffff !important;
        }

        .dark-mode .content-wrapper {
            background-color: #1a202c !important;
        }

        .dark-mode .breadcrumb {
            background-color: transparent !important;
        }

        .dark-mode .breadcrumb-item,
        .dark-mode .breadcrumb-item a {
            color: #cbd5e0 !important;
        }

        .dark-mode .text-muted {
            color: #a0aec0 !important;
        }

        .dark-mode .badge-light {
            background-color: #4a5568 !important;
            color: #e2e8f0 !important;
        }

        .dark-mode .modal-content {
            background-color: #2d3748 !important;
            color: #e2e8f0 !important;
        }

        .dark-mode .modal-header {
            border-bottom-color: #4a5568 !important;
        }

        .dark-mode .modal-footer {
            border-top-color: #4a5568 !important;
        }

        .dark-mode .dropdown-menu {
            background-color: #2d3748 !important;
            border-color: #4a5568 !important;
        }

        .dark-mode .dropdown-item {
            color: #e2e8f0 !important;
        }

        .dark-mode .dropdown-item:hover {
            background-color: #4a5568 !important;
        }

        .dark-mode .table tbody tr {
            background-color: #2d3748 !important;
        }

        .dark-mode .table tbody tr:hover {
            background-color: #4a5568 !important;
        }

        .dark-mode .table tbody td {
            color: #e2e8f0 !important;
            border-color: #4a5568 !important;
        }

        .dark-mode .navbar-nav .nav-link {
            color: #e2e8f0 !important;
        }

        .dark-mode .navbar-nav .nav-link:hover {
            color: #ffffff !important;
        }

        .dark-mode .user-panel .info {
            color: #e2e8f0 !important;
        }

        .dark-mode .brand-text {
            color: #e2e8f0 !important;
        }

        .main-sidebar {
            background: #1a202c !important;
            /* Modern Dark Sidebar */
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1) !important;
        }

        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active {
            background: var(--primary-gradient) !important;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4) !important;
            border-radius: 8px;
            margin: 0 10px;
        }

        .nav-link {
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 2px 10px;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .card {
            border: none !important;
            box-shadow: var(--card-shadow);
            border-radius: 16px !important;
            margin-bottom: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--hover-shadow);
        }

        .card-header {
            background-color: #fff !important;
            border-bottom: 1px solid #edf2f7 !important;
            padding: 1.25rem 1.5rem !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 700 !important;
            color: #2d3748 !important;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .card-title i {
            margin-right: 10px;
            font-size: 1.25rem;
            color: #4a5568;
        }

        .content-wrapper {
            background-color: #f7fafc !important;
            padding: 20px;
        }

        .main-header {
            border-bottom: 1px solid #edf2f7 !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        }

        .btn {
            border-radius: 10px !important;
            font-weight: 600 !important;
            padding: 0.6rem 1.2rem;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: var(--primary-gradient) !important;
            border: none !important;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.25) !important;
        }

        .table {
            border-collapse: separate;
            border-spacing: 0 8px;
            margin-top: -8px;
        }

        .table thead th {
            background-color: transparent;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05rem;
            font-weight: 800;
            color: #718096;
            border: none !important;
            padding: 1rem 1.5rem;
        }

        .table tbody tr {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f7fafc !important;
            transform: scale(1.005);
        }

        .table td {
            border: none !important;
            padding: 1.25rem 1.5rem;
            vertical-align: middle;
        }

        .badge {
            padding: 6px 12px !important;
            font-weight: 700 !important;
            border-radius: 20px !important;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.02em;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Glassmorphism for specific elements */
        .glass {
            background: rgba(255, 255, 255, 0.7) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('home') }}" class="nav-link" target="_blank">
                        <i class="fas fa-external-link-alt mr-1"></i> View Site
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Theme Toggle -->
                <li class="nav-item">
                    <a class="nav-link" id="theme-toggle" href="#" role="button" title="Toggle Dark Mode">
                        <i class="fas fa-moon"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user-circle mr-1"></i>
                        {{ Auth::guard('admin')->user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="{{ route('admin.settings.index') }}" class="dropdown-item">
                            <i class="fas fa-cog mr-2"></i> Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('admin.logout') }}" class="dropdown-item"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('admin.dashboard') }}" class="brand-link text-center">
                <span class="brand-text font-weight-light">{{ config('app.name', 'Admin Panel') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-header text-uppercase" style="font-size: 0.7rem; opacity: 0.7; letter-spacing: 1px;">E-Commerce</li>

                        <li class="nav-item {{ request()->routeIs('admin.categories.*') || request()->routeIs('admin.subcategories.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('admin.categories.*') || request()->routeIs('admin.subcategories.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-sitemap"></i>
                                <p>
                                    Categories
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.categories.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Categories</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.subcategories.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Sub Categories</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-header text-uppercase" style="font-size: 0.7rem; opacity: 0.7; letter-spacing: 1px;">Marketing Appearance</li>

                        <!-- Add Banners Menu Item Here -->
                        <li class="nav-item">
                            <a href="{{ route('admin.banners.index') }}"
                                class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-images"></i>
                                <p>Banners</p>
                            </a>
                        </li>

                        <!-- Add Discount Banners Menu Item Here -->
                        <li class="nav-item">
                            <a href="{{ route('admin.discount-banners.index') }}"
                                class="nav-link {{ request()->routeIs('admin.discount-banners.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-percent"></i>
                                <p>Discount Banners</p>
                            </a>
                        </li>
                        <!-- End Discount Banners Menu Item -->

                        <!-- Services Menu Item -->
                        <li class="nav-item">
                            <a href="{{ route('admin.services.index') }}"
                                class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-concierge-bell"></i>
                                <p>Services</p>
                            </a>
                        </li>

                        <li class="nav-header text-uppercase" style="font-size: 0.7rem; opacity: 0.7; letter-spacing: 1px;">Marketing & Content</li>

                        <!-- Blog Management Menu -->
                        <li class="nav-item {{ request()->routeIs('admin.blog-categories.*') || request()->routeIs('admin.blogs.*') || request()->routeIs('admin.blog-comments.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('admin.blog-categories.*') || request()->routeIs('admin.blogs.*') || request()->routeIs('admin.blog-comments.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-blog"></i>
                                <p>
                                    Blog Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.blog-categories.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.blog-categories.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Categories</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.blogs.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Blog Posts</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.blog-comments.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.blog-comments.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Comments</p>
                                        @php
                                        $pendingComments = \App\Models\Backend\BlogComment::where('approved', false)->count();
                                        @endphp
                                        @if($pendingComments > 0)
                                        <span class="badge badge-warning right">{{ $pendingComments }}</span>
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Instagram Posts Menu Item -->
                        <li class="nav-item">
                            <a href="{{ route('admin.instagram-posts.index') }}"
                                class="nav-link {{ request()->routeIs('admin.instagram-posts.*') ? 'active' : '' }}">
                                <i class="nav-icon fab fa-instagram"></i>
                                <p>Instagram Posts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.products.index') }}"
                                class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tshirt"></i>
                                <p>Products</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.orders.index') }}"
                                class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>
                                    Orders
                                    @php
                                    $pendingCount = \App\Models\Backend\Order::where('status', 'pending')->count();
                                    @endphp
                                    @if($pendingCount > 0)
                                    <span class="badge badge-warning right">{{ $pendingCount }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.contact-messages.index') }}"
                                class="nav-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>
                                    Contact Messages
                                    @php
                                    $newMessages = \App\Models\Backend\ContactMessage::where('is_read', false)->count();
                                    @endphp
                                    @if($newMessages > 0)
                                    <span class="badge badge-info right">{{ $newMessages }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>

                        <li class="nav-header text-uppercase" style="font-size: 0.7rem; opacity: 0.7; letter-spacing: 1px;">System & Settings</li>

                        <li class="nav-item">
                            <a href="{{ route('admin.reports.index') }}"
                                class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>Analytics & Reports</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.settings.index') }}"
                                class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>Settings</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('page_title', 'Dashboard')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                @yield('breadcrumb')
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <ul class="mb-0 pl-3">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; {{ date('Y') }} <a href="https://innoflexia.com" target="_blank" class="text-primary">Innoflexia</a>.</strong>
            All rights reserved.
        </footer>
    </div>

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @stack('scripts')

    <script>
        $(function() {
            // Initialize DataTables only if not already initialized
            $(document).ready(function() {
                if (!$.fn.DataTable.isDataTable('.datatable')) {
                    $('.datatable').DataTable({
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "responsive": true,
                        "pageLength": 10,
                        "language": {
                            "paginate": {
                                "previous": "‹",
                                "next": "›"
                            }
                        }
                    });
                }
            });

            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);

            // Enable tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // CSRF token setup for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Toastr options
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000"
            };

            const successMsg = "{{ session('success') }}";
            const errorMsg = "{{ session('error') }}";

            if (successMsg) {
                toastr.success(successMsg);
            }
            if (errorMsg) {
                toastr.error(errorMsg);
            }

            // Theme Toggle Logic
            const themeToggle = $('#theme-toggle');
            const body = $('body');
            const icon = themeToggle.find('i');

            // Check saved theme
            if (localStorage.getItem('admin-theme') === 'dark') {
                body.addClass('dark-mode');
                icon.removeClass('fa-moon').addClass('fa-sun');
            }

            themeToggle.on('click', function(e) {
                e.preventDefault();
                body.toggleClass('dark-mode');

                if (body.hasClass('dark-mode')) {
                    localStorage.setItem('admin-theme', 'dark');
                    icon.removeClass('fa-moon').addClass('fa-sun');
                } else {
                    localStorage.setItem('admin-theme', 'light');
                    icon.removeClass('fa-sun').addClass('fa-moon');
                }
            });
        });
    </script>
</body>

</html>