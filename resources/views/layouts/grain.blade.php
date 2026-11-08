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

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin-modern.css') }}?v={{ filemtime(public_path('css/admin-modern.css')) }}" rel="stylesheet">
    <script>
        // Terapkan tema sebelum render agar tidak berkedip
        (function () {
            try {
                var t = localStorage.getItem('sps_admin_theme') ||
                    (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                document.documentElement.setAttribute('data-theme', t);
            } catch (e) {}
        })();
    </script>
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
            var root = document.documentElement;
            var btn = document.getElementById('themeToggleBtn');
            var icon = document.getElementById('themeToggleIcon');
            var text = document.getElementById('themeToggleText');

            function render() {
                var dark = root.getAttribute('data-theme') === 'dark';
                if (icon) icon.className = (dark ? 'gd-moon' : 'gd-sun') + ' mr-1 text-warning';
                if (text) text.textContent = dark ? 'Dark' : 'Light';
            }

            if (btn) {
                btn.addEventListener('click', function () {
                    var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                    root.setAttribute('data-theme', next);
                    try { localStorage.setItem('sps_admin_theme', next); } catch (e) {}
                    render();
                });
            }
            render();
        });
    </script>
    @yield('scripts')
  </body>
</html>