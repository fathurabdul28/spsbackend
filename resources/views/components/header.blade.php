<!-- Header -->
<header class="header bg-body border-bottom">
  <nav class="navbar flex-nowrap p-0">
	<div class="navbar-brand-wrapper d-flex align-items-center col-auto py-2">
	  <a class="navbar-brand d-flex align-items-center text-decoration-none" href="/">
		<img class="mr-2" src="{{ asset('sehati.logo.png') }}" alt="Sehati Peduli Sesama" style="height: 36px; width: auto; object-fit: contain;">
		<span class="side-nav-hide-on-closed font-weight-bold text-dark" style="font-size: 1rem; letter-spacing: -0.2px;">
			Sehati Peduli Sesama
		</span>
	  </a>
	</div>

	<div class="header-content col px-md-3">
	  <div class="d-flex align-items-center">
		<!-- Side Nav Toggle -->
		<a class="js-side-nav header-invoker d-flex mr-md-2" href="#"
		   data-close-invoker="#sidebarClose"
		   data-target="#sidebar"
		   data-target-wrapper="body">
		  <i class="gd-align-left"></i>
		</a>
		<!-- End Side Nav Toggle -->

		<div class="ml-auto d-flex align-items-center">
			<!-- Dark / Light Mode Toggle Button -->
			<button id="themeToggleBtn" type="button" class="btn btn-sm btn-outline-secondary mr-3 d-flex align-items-center" title="Beralih Mode Gelap/Terang" style="border-radius: 20px; padding: 4px 12px; font-size: 0.85rem;">
				<i id="themeToggleIcon" class="gd-sun mr-1"></i>
				<span id="themeToggleText">Light</span>
			</button>

			<!-- User Notifications -->
			<div class="dropdown">
				<a id="notificationsInvoker" class="header-invoker" href="#" aria-controls="notifications" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-target="#notifications" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-animation-in="fadeIn" data-unfold-animation-out="fadeOut">
					<span class="indicator indicator-bordered indicator-top-right indicator-primary rounded-circle"></span>
					<i class="gd-bell"></i>
				</a>

				<div id="notifications" class="dropdown-menu dropdown-menu-center py-0 mt-4 w-18_75rem w-md-22_5rem unfold-css-animation unfold-hidden" aria-labelledby="notificationsInvoker" style="animation-duration: 300ms;">
					<div class="card">
						<div class="card-header d-flex align-items-center border-bottom py-3">
							<h5 class="mb-0">Notifikasi</h5>
							<a class="link small ml-auto" href="#">Bersihkan</a>
						</div>

						<div class="card-body p-0">
							<div class="list-group list-group-flush">
								<div class="list-group-item list-group-item-action">
									<div class="d-flex align-items-center text-nowrap mb-2">
										<i class="gd-info-alt icon-text text-primary mr-2"></i>
										<h6 class="font-weight-semi-bold mb-0">Sistem Aktif</h6>
										<span class="list-group-item-date text-muted ml-auto">Baru saja</span>
									</div>
									<p class="mb-0">
										Selamat datang di Panel Admin Sehati Peduli Sesama.
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End User Notifications -->

			<!-- User Avatar -->
			<div class="dropdown mx-2">
			  <a id="profileMenuInvoker" class="header-complex-invoker d-flex align-items-center text-decoration-none" href="#" aria-controls="profileMenu" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-target="#profileMenu" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-animation-in="fadeIn" data-unfold-animation-out="fadeOut">
				<span class="mr-md-2 avatar-placeholder rounded-circle bg-primary text-white font-weight-bold d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.9rem;">
					{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
				</span>
				<span class="d-none d-md-block text-dark font-weight-semi-bold">{{ Auth::user()->name ?? 'Admin' }}</span>
				<i class="gd-angle-down d-none d-md-block ml-2 text-muted"></i>
			  </a>

			  <ul id="profileMenu" class="unfold unfold-user unfold-light unfold-top unfold-centered position-absolute pt-2 pb-1 mt-4 unfold-css-animation unfold-hidden fadeOut" aria-labelledby="profileMenuInvoker" style="animation-duration: 300ms;">
				<li class="unfold-item">
				  <a class="unfold-link d-flex align-items-center text-nowrap" href="{{ route('profile.edit') }}">
					<span class="unfold-item-icon mr-3">
					  <i class="gd-user"></i>
					</span>
					Profil Saya
				  </a>
				</li>
				<li class="unfold-item unfold-item-has-divider">
				  <a class="unfold-link d-flex align-items-center text-nowrap" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
					<span class="unfold-item-icon mr-3">
					  <i class="gd-power-off"></i>
					</span>
					Keluar (Logout)
				  </a>
				  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					  @csrf
				  </form>
				</li>
			  </ul>
			</div>
			<!-- End User Avatar -->
		</div>
	  </div>
	</div>
  </nav>
</header>
<!-- End Header -->