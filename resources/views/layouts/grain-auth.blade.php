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
        (function () {
            try {
                var t = localStorage.getItem('sps_admin_theme') ||
                    (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                document.documentElement.setAttribute('data-theme', t);
            } catch (e) {}
        })();
    </script>
</head>
<body>
    <button id="themeToggleBtn" type="button" class="btn btn-sm btn-outline-secondary auth-theme-toggle" aria-label="Ganti tema">
        <i id="themeToggleIcon" class="gd-sun mr-1 text-warning"></i><span id="themeToggleText">Light</span>
    </button>
    <main class="main">

      <div class="content auth-wrap">
		@yield('content')
	  </div>
    </main>
	
	<script src="{{ mix('graindashboard/js/graindashboard.js') }}"></script>
	<script src="{{ mix('graindashboard/js/graindashboard.vendor.js') }}"></script>
	<script>
		(function () {
			var root = document.documentElement, btn = document.getElementById('themeToggleBtn'),
				icon = document.getElementById('themeToggleIcon'), text = document.getElementById('themeToggleText');
			function render() {
				var dark = root.getAttribute('data-theme') === 'dark';
				icon.className = (dark ? 'gd-moon' : 'gd-sun') + ' mr-1 text-warning';
				text.textContent = dark ? 'Dark' : 'Light';
			}
			btn.addEventListener('click', function () {
				var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
				root.setAttribute('data-theme', next);
				try { localStorage.setItem('sps_admin_theme', next); } catch (e) {}
				render();
			});
			render();
		})();
	</script>
	@yield('scripts')
</body>
</html>