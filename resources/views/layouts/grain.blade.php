<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sehati Peduli Sesama - @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('sehati.logo.png') }}">

    <!-- Styles -->
    <link href="{{ mix('graindashboard/css/graindashboard.css') }}" rel="stylesheet">

    <!-- Dark Mode CSS Overrides -->
    <style id="darkModeStyles">
        body.dark-mode {
            background-color: #0f172a !important;
            color: #f1f5f9 !important;
        }
        body.dark-mode .header {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }
        body.dark-mode .side-nav {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }
        body.dark-mode .side-nav-menu-link {
            color: #cbd5e1 !important;
        }
        body.dark-mode .side-nav-menu-item.active > .side-nav-menu-link,
        body.dark-mode .side-nav-menu-link:hover {
            color: #38bdf8 !important;
            background-color: #334155 !important;
        }
        body.dark-mode .sidebar-heading {
            color: #64748b !important;
        }
        body.dark-mode .card {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }
        body.dark-mode .card-header,
        body.dark-mode .card-footer {
            border-color: #334155 !important;
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
        }
        body.dark-mode .table {
            color: #e2e8f0 !important;
        }
        body.dark-mode .table th,
        body.dark-mode .table td {
            border-color: #334155 !important;
        }
        body.dark-mode .form-control,
        body.dark-mode .custom-select {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }
        body.dark-mode .text-dark {
            color: #f8fafc !important;
        }
        body.dark-mode .text-muted {
            color: #94a3b8 !important;
        }
        body.dark-mode .list-group-item {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }
    </style>
</head>

  <body class="has-sidebar has-fixed-sidebar-and-header">
	@include('components.header')

    <main class="main">
	  @include('components.sidebar')
      

      <div class="content">
        <div class="py-4 px-3 px-md-4">

			@yield('content')

        </div>
		
		@include('components.footer')

      </div>
    </main>


	<script src="{{ mix('graindashboard/js/graindashboard.js') }}"></script>
	<script src="{{ mix('graindashboard/js/graindashboard.vendor.js') }}"></script>
    
    <!-- Dark/Light Theme Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const themeBtn = document.getElementById('themeToggleBtn');
            const themeIcon = document.getElementById('themeToggleIcon');
            const themeText = document.getElementById('themeToggleText');
            
            // Check saved theme in localStorage
            const savedTheme = localStorage.getItem('sps_admin_theme') || 'light';
            if (savedTheme === 'dark') {
                applyDarkMode(true);
            } else {
                applyDarkMode(false);
            }

            if (themeBtn) {
                themeBtn.addEventListener('click', function () {
                    const isDark = document.body.classList.contains('dark-mode');
                    applyDarkMode(!isDark);
                    localStorage.setItem('sps_admin_theme', !isDark ? 'dark' : 'light');
                });
            }

            function applyDarkMode(enableDark) {
                if (enableDark) {
                    document.body.classList.add('dark-mode');
                    if (themeIcon) themeIcon.className = 'gd-moon mr-1 text-warning';
                    if (themeText) themeText.textContent = 'Dark';
                    if (themeBtn) {
                        themeBtn.classList.remove('btn-outline-secondary');
                        themeBtn.classList.add('btn-outline-light');
                    }
                } else {
                    document.body.classList.remove('dark-mode');
                    if (themeIcon) themeIcon.className = 'gd-sun mr-1 text-warning';
                    if (themeText) themeText.textContent = 'Light';
                    if (themeBtn) {
                        themeBtn.classList.remove('btn-outline-light');
                        themeBtn.classList.add('btn-outline-secondary');
                    }
                }
            }
        });
    </script>
    @yield('scripts')
  </body>
</html>