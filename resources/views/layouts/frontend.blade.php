<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Desa Karangrejo')</title>
    <meta name="description" content="@yield('description', 'Website Resmi Desa Karangrejo')">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #059669;
            --accent-color: #dc2626;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--gray-700);
        }
        
        .navbar-brand img {
            height: 38px;
            width: auto;
            object-fit: contain;
        }
        .navbar-brand span {
            font-size: 1.25rem;
            margin-bottom: 0;
        }
        .navbar-nav .nav-link {
            font-weight: 500;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
        }
        .navbar-nav .nav-link.active, .navbar-nav .nav-link:focus {
            color: var(--primary-color) !important;
        }
        .navbar-nav .dropdown-menu {
            min-width: 200px;
        }
        @media (max-width: 991.98px) {
            .navbar-brand {
                margin-bottom: 0.5rem;
            }
            .navbar-nav {
                margin-bottom: 1rem;
            }
            .navbar .input-group {
                width: 100%;
            }
        }
        
        .hero-section {
            position: relative;
            color: white;
            padding: 100px 0 80px;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), var(--hero-bg, '') center/cover no-repeat;
            background-attachment: fixed;
            min-height: 80vh;
            display: flex;
            align-items: center;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        @media (max-width: 767.98px) {
            .hero-section {
                padding: 80px 0 60px;
                min-height: 70vh;
            }
            
            .hero-section h1 {
                font-size: 2.5rem;
                margin-bottom: 1rem;
            }
            
            .hero-section .lead {
                font-size: 1.25rem;
                margin-bottom: 1.5rem;
            }
            
            .hero-section .btn {
                padding: 0.6rem 1.5rem;
                font-size: 0.9rem;
            }
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.7) 0%, rgba(5, 150, 105, 0.7) 100%);
            z-index: 1;
        }
        
        .hero-section h1 {
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        
        .hero-section .lead {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            font-weight: 300;
        }
        
        .hero-section .btn {
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .hero-section .btn-light {
            background-color: white;
            color: var(--primary-color);
            border: 2px solid white;
        }
        
        .hero-section .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.5);
            color: white;
            background-color: transparent;
        }
        
        .hero-section .btn-light:hover {
            background-color: transparent;
            color: white;
        }
        
        .hero-section .btn-outline-light:hover {
            background-color: white;
            color: var(--primary-color);
            border-color: white;
        }
        
        .hero-section > .container {
            position: relative;
            z-index: 2;
        }
        
        .card {
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .section-padding {
            padding: 80px 0;
        }
        
        .footer {
            background-color: var(--gray-800);
            color: var(--gray-300);
            padding: 50px 0 20px;
        }
        
        .footer a {
            color: var(--gray-300);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer a:hover {
            color: white;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            padding: 0.75rem 1rem;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .announcement-bar {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
        }

        .stats-counter {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    @include('frontend.partials.navbar')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('frontend.partials.footer')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('scripts')
</body>
</html>