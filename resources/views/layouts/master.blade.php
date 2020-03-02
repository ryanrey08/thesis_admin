
<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard | {{ config('app.name', 'Laravel') }}</title>
	
	<link rel="stylesheet" type="text/css" href="/css/app.css">



</head>
<body class="sidebar-mini layout-navbar-fixed sidebar-collapse">
	<div class="wrapper" id="app">

		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-dark navbar-olive">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
				</li>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="index3.html" class="nav-link">Home</a>
				</li>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="#" class="nav-link">Contact</a>
				</li>
			</ul>

			<!-- SEARCH FORM -->
			<form class="form-inline ml-3">
				<div class="input-group input-group-sm">
					<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
					<div class="input-group-append">
						<button class="btn btn-navbar" type="submit">
							<i class="fas fa-search"></i>
						</button>
					</div>
				</div>
			</form>

			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">

				<li class="nav-item">
					<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
						<i class="fas fa-th-large"></i>
					</a>
				</li>
			</ul>
		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar elevation-4 sidebar-light-olive">
			<!-- Brand Logo -->
			<a href="/dashboard" class="brand-link elevation-4 navbar-olive">
				<img src="/img/design/logos (2)/logo.png" alt="PnC Store" class="brand-image img-circle elevation-3" style="opacity: .8">

				<span class="brand-text font-weight-light text-center text-light">PnC Store</span>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar user panel (optional) -->
				@guest
				@else
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<!-- <div class="image"> -->
						<router-link to="/profile" class="nav-link" data-toggle="tooltip" title="{{ Auth::user()->name }}">
						<img src="{{ Auth::user()->photo }}" class="img-circle elevation-2" alt="User Image">
					</router-link>
					<!-- </div> -->
					<div class="info">
						<a class="d-block font-weight-bold">{{ Auth::user()->name }}</a>
						<span class="d-block font-weight-bold" style="font-size: .65rem;"><i class="far fa-dot-circle fa-fw green hidden "></i>{{ Auth::user()->getRole(Auth::user()->role_id) }}</span>
					</div>
				</div>
				@endguest


				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
	  					<!-- Add icons to the links using the .nav-icon class
	  					with font-awesome or any other icon font library -->
						
						<li class="nav-item">
							<router-link to="/dashboard" class="nav-link">
								<i class="nav-icon fas fa-tachometer-alt pink" aria-hidden="true"></i>
								<p>
									Dashboard
								</p>
							</router-link>
						</li>

						@if (Auth::user()->role_id == 1)
						
						@auth
						<!-- Management -->
						<li class="nav-item has-treeview">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-users-cog green" aria-hidden="true"></i>
								<p>
									Account Management
									<i class="right fas fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<router-link to="/management/staff" class="nav-link">
										<i class="nav-icon fas fa-angle-double-right green"></i>
										<p>
											Staff
										</p>
									</router-link>
								</li>
								<li class="nav-item">
									<router-link to="/management/customer" class="nav-link">
										<i class="nav-icon fas fa-angle-double-right green"></i>
										<p>
											Customer
										</p>
									</router-link>
								</li>
							</ul>
						</li>
						
						@endauth
						@endif
						
						@if (Auth::user()->role_id == 1 || Auth::user()->role_id == 3)

						{{-- Point-of-Sales Link --}}
						<li class="nav-item">
							<router-link to="/pos" class="nav-link">
								<i class="nav-icon fa fa-cash-register indigo" aria-hidden="true"></i>
								<p>
									Point-of-Sales
								</p>
							</router-link>
						</li>


						@endif
						

						@if (Auth::user()->role_id == 4)

						{{-- Products Link --}}
						<li class="nav-item has-treeview">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-tshirt yellow"></i>
								<p>
									Product
									<i class="right fas fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<router-link to="/product" class="nav-link">
										<i class="nav-icon fas fa-angle-double-right yellow"></i>
										<p>
											Product
										</p>
									</router-link>
								</li>

								<li class="nav-item">
									<router-link to="/collections" class="nav-link">
										<i class="nav-icon fas fa-angle-double-right yellow"></i>
										<p>
											Collections
										</p>
									</router-link>
								</li>

								{{-- <li class="nav-item">
									<router-link to="/inventory" class="nav-link">
										<i class="nav-icon fas fa-angle-double-right yellow"></i>
										<p>
											Inventory
										</p>
									</router-link>
								</li>

								<li class="nav-item">
									<router-link to="/porder" class="nav-link">
										<i class="nav-icon fas fa-angle-double-right yellow"></i>
										<p>
											Purchase Order
										</p>
									</router-link>
								</li> --}}

							</ul>
						</li>

						@endif


						@if (Auth::user()->role_id == 4 || Auth::user()->role_id == 5)
						{{-- Inventory Link --}}
						<li class="nav-item has-treeview">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-tshirt purple"></i>
								<p>
									Inventory Management
									<i class="right fas fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<router-link to="/inventory" class="nav-link">
										<i class="nav-icon fas fa-angle-double-right purple"></i>
										<p>
											Inventory
										</p>
									</router-link>
								</li>

								<li class="nav-item">
									<router-link to="/porder" class="nav-link">
										<i class="nav-icon fas fa-angle-double-right purple"></i>
										<p>
											Purchase Order
										</p>
									</router-link>
								</li>

								<li class="nav-item">
									<router-link to="/vendor" class="nav-link">
										<i class="nav-icon fas fa-angle-double-right purple"></i>
										<p>
											Vendors
										</p>
									</router-link>
								</li>

							</ul>
						</li>
						@endif

						
						@if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
						{{-- Order Management --}}
						<li class="nav-item has-treeview">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-cart-arrow-down orange"></i>
								<p>
									Order Management
									<i class="right fas fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<router-link to="/orders" class="nav-link">
										<i class="nav-icon fas fa-angle-double-right orange"></i>
										<p>
											Orders
										</p>
									</router-link>
								</li>
								<li class="nav-item">
									<router-link to="/orders/shipment" class="nav-link">
										<i class="nav-icon fas fa-angle-double-right orange"></i>
										<p>
											Shipping
										</p>
									</router-link>
								</li>
							</ul>
						</li>
						@endif


						@if (Auth::user()->role_id == 1)
					
						<!-- Settings -->
						<li class="nav-item has-treeview">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-cogs gray"></i>
								<p>
									Settings
									<i class="right fas fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<router-link to="/settings/shipping" class="nav-link">
										<i class="nav-icon fas fa-angle-double-right gray"></i>
										<p>
											Shipping
										</p>
									</router-link>
								</li>
								<li class="nav-item">
									<router-link to="/settings/store" class="nav-link">
										<i class="nav-icon fas fa-angle-double-right gray"></i>
										<p>
											Online Store
										</p>
									</router-link>
								</li>
							</ul>
						</li>

						@endif


					  	<li class="nav-item">
							<a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
								<i class="nav-icon fas fa-power-off red" aria-hidden="true"></i>
								<p>
									{{ __('Logout') }}
								</p>

							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
						</li>
					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>

		<div class="content-wrapper">
			<vue-progress-bar></vue-progress-bar>
			<router-view></router-view>
		
		</div>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
			<div class="p-3">
				<h5>Title</h5>
				<p>Sidebar content</p>
			</div>
		</aside>
		<!-- /.control-sidebar -->

		<!-- Main Footer -->
		<footer class="main-footer">
			<!-- To the right -->
			<div class="float-right d-none d-sm-inline">
				Anything you want
			</div>
			<!-- Default to the left -->
			<strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
		</footer>
	</div>
	<!-- ./wrapper -->

</body>


<script type="text/javascript" src="/js/app.js"></script>


</html>
