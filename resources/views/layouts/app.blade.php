<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('page_title', 'Dashboard') | AI Sales Page Generator</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
      :root {
        --bs-primary: #0066cc;
        --bs-secondary: #0052a3;
      }

      body {
        background-color: #f5f6f7;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }

      .sidebar {
        background: #0066cc;
        color: white;
        min-height: 100vh;
        padding: 20px;
      }

      .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8);
        border-radius: 8px;
        margin-bottom: 8px;
        transition: all 0.3s ease;
      }

      .sidebar .nav-link:hover,
      .sidebar .nav-link.active {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
      }

      .navbar {
        background: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .navbar-brand {
        color: #0066cc !important;
        font-weight: 700;
      }

      .main-content {
        padding: 30px;
      }

      .card {
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
      }

      .card-header {
        background: #0066cc;
        color: white;
        border: none;
        border-radius: 12px 12px 0 0;
        padding: 20px;
      }

      .btn-primary {
        background: #0066cc;
        border: none;
      }

      .btn-primary:hover {
        background: #0052a3;
      }

      .table {
        background: white;
      }

      .table thead {
        background-color: #f5f6f7;
        border-top: 1px solid #dee2e6;
      }

      .badge {
        padding: 8px 12px;
        border-radius: 6px;
      }

      .alert {
        border-radius: 8px;
        border: none;
      }

      .dropdown-menu {
        border-radius: 8px;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      }
    </style>

    @stack('page-styles')
  </head>

  <body>
    <div class="d-flex">
      <!-- Sidebar -->
      @include('layouts.partials.sidebar')

      <!-- Main Content -->
      <div class="flex-grow-1">
        <!-- Navbar -->
        @include('layouts.partials.navbar')

        <!-- Content -->
        <div class="main-content">
          @yield('content')
        </div>

        <!-- Footer -->
        @include('layouts.partials.footer')
      </div>
    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @stack('page-scripts')

    <!-- Page JS -->
    @stack('page-scripts')
  </body>
</html>
