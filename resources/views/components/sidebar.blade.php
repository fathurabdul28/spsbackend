<!-- Sidebar Nav -->
<aside id="sidebar" class="js-custom-scroll side-nav">
<ul id="sideNav" class="side-nav-menu side-nav-menu-top-level mb-0">

  <!-- Title -->
  <li class="sidebar-heading h6">Dashboard</li>

  <!-- Dashboard -->
  <li class="side-nav-menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
	<a class="side-nav-menu-link media align-items-center" href="{{ route('dashboard') }}">
	  <span class="side-nav-menu-icon d-flex mr-3">
		<i class="gd-dashboard"></i>
	  </span>
	  <span class="side-nav-fadeout-on-closed media-body">Dashboard</span>
	</a>
  </li>

  <!-- Title -->
  <li class="sidebar-heading h6">Manajemen Donasi</li>

  <!-- Program -->
  <li class="side-nav-menu-item side-nav-has-menu {{ Request::is('programs*') ? 'open active' : '' }}">
	<a class="side-nav-menu-link media align-items-center" href="#" data-target="#subPrograms">
	  <span class="side-nav-menu-icon d-flex mr-3">
		<i class="gd-layers"></i>
	  </span>
	  <span class="side-nav-fadeout-on-closed media-body">Program</span>
	  <span class="side-nav-control-icon d-flex">
		<i class="gd-angle-right side-nav-fadeout-on-closed"></i>
	  </span>
	  <span class="side-nav__indicator side-nav-fadeout-on-closed"></span>
	</a>
	<ul id="subPrograms" class="side-nav-menu side-nav-menu-second-level mb-0">
	  <li class="side-nav-menu-item {{ Request::is('programs') && !Request::is('programs/create') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{ route('program.index') }}">Semua Program</a>
	  </li>
	  <li class="side-nav-menu-item {{ Request::is('programs/create') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{ route('program.create') }}">Tambah Program</a>
	  </li>
	</ul>
  </li>

  <!-- Donasi -->
  <li class="side-nav-menu-item {{ Request::is('donations*') ? 'active' : '' }}">
	<a class="side-nav-menu-link media align-items-center" href="{{ route('donation.index') }}">
	  <span class="side-nav-menu-icon d-flex mr-3">
		<i class="gd-wallet"></i>
	  </span>
	  <span class="side-nav-fadeout-on-closed media-body">Donasi</span>
	</a>
  </li>

  <!-- Kategori -->
  <li class="side-nav-menu-item side-nav-has-menu {{ Request::is('categories*') ? 'open active' : '' }}">
	<a class="side-nav-menu-link media align-items-center" href="#" data-target="#subCategories">
	  <span class="side-nav-menu-icon d-flex mr-3">
		<i class="gd-tag"></i>
	  </span>
	  <span class="side-nav-fadeout-on-closed media-body">Kategori</span>
	  <span class="side-nav-control-icon d-flex">
		<i class="gd-angle-right side-nav-fadeout-on-closed"></i>
	  </span>
	  <span class="side-nav__indicator side-nav-fadeout-on-closed"></span>
	</a>
	<ul id="subCategories" class="side-nav-menu side-nav-menu-second-level mb-0">
	  <li class="side-nav-menu-item {{ Request::is('categories') && !Request::is('categories/create') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{ route('category.index') }}">Semua Kategori</a>
	  </li>
	  <li class="side-nav-menu-item {{ Request::is('categories/create') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{ route('category.create') }}">Tambah Kategori</a>
	  </li>
	</ul>
  </li>

  <!-- Title -->
  <li class="sidebar-heading h6">Konten</li>

  <!-- Berita -->
  <li class="side-nav-menu-item side-nav-has-menu {{ Request::is('news*') ? 'open active' : '' }}">
	<a class="side-nav-menu-link media align-items-center" href="#" data-target="#subNews">
	  <span class="side-nav-menu-icon d-flex mr-3">
		<i class="gd-file"></i>
	  </span>
	  <span class="side-nav-fadeout-on-closed media-body">Berita</span>
	  <span class="side-nav-control-icon d-flex">
		<i class="gd-angle-right side-nav-fadeout-on-closed"></i>
	  </span>
	  <span class="side-nav__indicator side-nav-fadeout-on-closed"></span>
	</a>
	<ul id="subNews" class="side-nav-menu side-nav-menu-second-level mb-0">
	  <li class="side-nav-menu-item {{ Request::is('news') && !Request::is('news/create') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{ route('news.index') }}">Semua Berita</a>
	  </li>
	  <li class="side-nav-menu-item {{ Request::is('news/create') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{ route('news.create') }}">Tambah Berita</a>
	  </li>
	</ul>
  </li>

  <!-- Title -->
  <li class="sidebar-heading h6">Pengaturan</li>

  <!-- Bank Account -->
  <li class="side-nav-menu-item side-nav-has-menu {{ Request::is('bank-accounts*') ? 'open active' : '' }}">
	<a class="side-nav-menu-link media align-items-center" href="#" data-target="#subBankAccounts">
	  <span class="side-nav-menu-icon d-flex mr-3">
		<i class="gd-credit-card"></i>
	  </span>
	  <span class="side-nav-fadeout-on-closed media-body">Rekening Bank</span>
	  <span class="side-nav-control-icon d-flex">
		<i class="gd-angle-right side-nav-fadeout-on-closed"></i>
	  </span>
	  <span class="side-nav__indicator side-nav-fadeout-on-closed"></span>
	</a>
	<ul id="subBankAccounts" class="side-nav-menu side-nav-menu-second-level mb-0">
	  <li class="side-nav-menu-item {{ Request::is('bank-accounts') && !Request::is('bank-accounts/create') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{ route('bank-account.index') }}">Semua Rekening</a>
	  </li>
	  <li class="side-nav-menu-item {{ Request::is('bank-accounts/create') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{ route('bank-account.create') }}">Tambah Rekening</a>
	  </li>
	</ul>
  </li>

  <!-- Web Settings -->
  <li class="side-nav-menu-item {{ Request::is('web-settings*') ? 'active' : '' }}">
	<a class="side-nav-menu-link media align-items-center" href="{{ route('web-setting.edit') }}">
	  <span class="side-nav-menu-icon d-flex mr-3">
		<i class="gd-settings"></i>
	  </span>
	  <span class="side-nav-fadeout-on-closed media-body">Pengaturan Web</span>
	</a>
  </li>

  <!-- Title -->
  <li class="sidebar-heading h6">Pengguna</li>

  <!-- Users -->
  <li class="side-nav-menu-item side-nav-has-menu {{ Request::is('users*') ? 'open active' : '' }}">
	<a class="side-nav-menu-link media align-items-center" href="#" data-target="#subUsers">
	  <span class="side-nav-menu-icon d-flex mr-3">
		<i class="gd-user"></i>
	  </span>
	  <span class="side-nav-fadeout-on-closed media-body">Pengguna</span>
	  <span class="side-nav-control-icon d-flex">
		<i class="gd-angle-right side-nav-fadeout-on-closed"></i>
	  </span>
	  <span class="side-nav__indicator side-nav-fadeout-on-closed"></span>
	</a>
	<ul id="subUsers" class="side-nav-menu side-nav-menu-second-level mb-0">
	  <li class="side-nav-menu-item {{ Request::is('users') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{ route('user.index') }}">Semua Pengguna</a>
	  </li>
	  <li class="side-nav-menu-item {{ Request::is('users/create') ? 'active' : '' }}">
		<a class="side-nav-menu-link" href="{{ route('user.create') }}">Tambah Pengguna</a>
	  </li>
	</ul>
  </li>

</ul>
</aside>
<!-- End Sidebar Nav -->