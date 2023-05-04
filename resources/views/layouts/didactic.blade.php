<!doctype html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="msapplication-TileColor" content="#0061da">
		<meta name="theme-color" content="#1643a3">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<link rel="icon" href="favicon.ico" type="image/x-icon"/>
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<!-- Title -->
		<title>{{$actual ?? env('APP_NAME')}}</title>

        <!--Font Awesome-->
		<link href="/assets/{{$theme}}/plugins/fontawesome-free/css/all.css" rel="stylesheet">

		<!-- Font family -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet">

		<!-- Dashboard Css -->
		<link href="/assets/{{$theme}}/css/dashboard.css" rel="stylesheet" />

		<!-- css custom in functie de teme -->
		<link href="/assets/{{$theme}}/css/theme.css" rel="stylesheet" />

		<!-- Custom scroll bar css-->
		<link href="/assets/{{$theme}}/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />

		<!-- Sidemenu Css -->
		<link href="/assets/{{$theme}}/plugins/toggle-sidebar/css/sidemenu.css" rel="stylesheet">

		<!-- c3.js Charts Plugin -->
		<link href="/assets/{{$theme}}/plugins/charts-c3/c3-chart.css" rel="stylesheet" />

		<!---Font icons-->
		<link href="/assets/{{$theme}}/plugins/iconfonts/plugin.css" rel="stylesheet" />

		<!-- select2 Plugin -->
		<link href="/assets/{{$theme}}/plugins/select2/select2.min.css" rel="stylesheet" />

		<!-- Accordion Css -->
		<link href="/assets/{{$theme}}/plugins/accordion/accordion.css" rel="stylesheet" />

		<link href="/assets/generale/admin.css" rel="stylesheet" />
		<link href="/assets/generale/didactic.css" rel="stylesheet" />
	</head>
	<body class="app sidebar-mini rtl">
		<div id="global-loader" ><div class="showbox"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div></div>
		<div class="page">
			<div class="page-main">
				<!-- Navbar-->
				<header class="app-header header">
					<!-- Header Background Animation-->
					<div id="particles-js"  class=""></div>
					<!-- Navbar Right Menu-->
					<div class="container-fluid">
						<div class="d-flex">
							<a class="header-brand" href="/">
								<img alt="logo" class="header-brand-img" src="/imagini/{{env('APP_LOGO')}}">
							</a>
							<a aria-label="" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a>
							<div class="d-flex order-lg-2 ml-auto">
								<div class="dropdown">
									<a class="nav-link pr-0 leading-none d-flex" data-toggle="dropdown" href="#">
										<span class="avatar avatar-md brround" style="background-image: url(<?=($cd->avatar?'/uploads/img_utilizatori/small/'.$cd->avatar:'/imagini/no-avatar.png')?>)"></span>
										<span class="ml-2 d-none d-lg-block">
											<span class="text-white">{{$cd->nume_cd ? $cd->nume_cd." ".$cd->prenume_cd: 'Webis'}}</span>
										</span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="dropdown-icon mdi mdi-logout-variant"></i>Logout</a>
										<form action="{{ route('logout') }}" id="logout-form" method="post">@csrf</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</header>
				<!-- Sidebar menu-->
				<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
				<aside class="app-sidebar">
					<div class="app-sidebar__user">
						<div class="dropdown">
							<a class="nav-link p-0 leading-none d-flex" data-toggle="dropdown" href="#">
								<span class="avatar avatar-md brround" style="background-image: url(<?=($cd->avatar?'/uploads/img_utilizatori/small/'.$cd->avatar:'/imagini/no-avatar.png')?>)"></span>
								<span class="ml-2 "><span class=" app-sidebar__user-name font-weight-semibold">{{$cd->nume_cd ? $cd->nume_cd." ".$cd->prenume_cd: 'Webis'}}</span><br>
									<span class="text-muted app-sidebar__user-name text-sm"> {{$cd->email_cd ? $cd->email_cd: 'Webis'}}</span>
								</span>
							</a>
						</div>
					</div>
					<ul class="side-menu">
						<!-- meniu -->
						<li>
							<a class="side-menu__item" href="/acasa"><i class="side-menu__icon fas fa-home"></i><span class="side-menu__label">Acasa</span></a>
						</li>
						<li>
							<a class="side-menu__item" href="/cereri-granturi"><i class="side-menu__icon fas fa-file"></i><span class="side-menu__label">Cerere grant</span></a>
						</li>
						<li>
							<a class="side-menu__item" href="/proiecte"><i class="side-menu__icon fas fa-project-diagram"></i><span class="side-menu__label">Proiecte</span></a>
						</li>
						<li>
							<a class="side-menu__item" href="/granturi"><i class="side-menu__icon fas fa-file-alt"></i><span class="side-menu__label">Granturi</span></a>
						</li>
					</ul>
					<div class="box_switch">
						<i class="fas fa-sun <?=($theme=='light'?'galben':'')?>"></i>
						<label class="custom-switch switch_theme">
							<input type="checkbox" <?=($theme=='dark'?'checked':'')?> name="switch-theme" class="custom-switch-input">
							<span class="custom-switch-indicator"></span>
						</label>
						<i class="fas fa-moon <?=($theme=='dark'?'galben':'')?>"></i>
					</div>
				</aside>
				
				<div class="app-content my-3 my-md-5">
					<div class="side-app">
						<div class="page-header">
							<h4 class="page-title">{{$actual ?? env('APP_NAME')}}</h4>
						</div>
						@include('inc.mesaje')
						@yield('content')
					</div>
					<!--footer-->
					<footer class="footer">
						<div class="container">
							<div class="row align-items-center flex-row-reverse">
								<div class="col-md-12 col-sm-12 mt-3 mt-lg-0 text-center">
									Copyright © {{date('Y')}} <a href="#">{{env('APP_NAME')}}</a>. Designed by <a target="blank" href="https://webis.ro">webis.ro</a> All rights reserved.
								</div>
							</div>
						</div>
					</footer>
					<!-- End Footer-->
				</div>
			</div>
		</div>

		<!-- Back to top -->
		<a href="#top" id="back-to-top" style="display: inline;"><i class="fas fa-angle-up"></i></a>

		<!-- Dashboard Core -->
		<script src="/assets/{{$theme}}/js/vendors/jquery-3.2.1.min.js"></script>
		<script src="/assets/{{$theme}}/js/vendors/bootstrap.bundle.min.js"></script>
		<script src="/assets/{{$theme}}/js/vendors/jquery.sparkline.min.js"></script>
		<script src="/assets/{{$theme}}/js/vendors/selectize.min.js"></script>
		<script src="/assets/{{$theme}}/js/vendors/jquery.tablesorter.min.js"></script>
		<script src="/assets/{{$theme}}/js/vendors/circle-progress.min.js"></script>
		<script src="/assets/{{$theme}}/plugins/rating/jquery.rating-stars.js"></script>
		<!-- Side menu js -->
		<script src="/assets/{{$theme}}/plugins/toggle-sidebar/js/sidemenu.js"></script>

		<!-- Custom scroll bar Js-->
		<script src="/assets/{{$theme}}/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

		<!-- c3.js Charts Plugin -->
		<script src="/assets/{{$theme}}/plugins/charts-c3/d3.v5.min.js"></script>
		<script src="/assets/{{$theme}}/plugins/charts-c3/c3-chart.js"></script>

		<!-- Input Mask Plugin -->
		<script src="/assets/{{$theme}}/plugins/input-mask/jquery.mask.min.js"></script>

        <!-- Index Scripts -->
		<script src="/assets/{{$theme}}/js/index.js"></script>

		<!-- animation -->
        <script src="/assets/{{$theme}}/plugins/particles/particles.js"></script>
		<script src="/assets/{{$theme}}/plugins/particles/particlesapp_default.js"></script>

		<!--Counters -->
		<script src="/assets/{{$theme}}/plugins/counters/counterup.min.js"></script>
		<script src="/assets/{{$theme}}/plugins/counters/waypoints.min.js"></script>

		<!--  Chart js -->
		<script src="/assets/{{$theme}}/plugins/chart/Chart.bundle.js"></script>

		<!-- Data tables -->
		<script src="/assets/{{$theme}}/plugins/datatable/jquery.dataTables.min.js"></script>
		<script src="/assets/{{$theme}}/plugins/datatable/dataTables.bootstrap4.min.js"></script>

		<!-- Sweet Alert -->
		<script src="/assets/{{$theme}}/plugins/sweet-alert/sweet-alert2.js"></script>
		<script src="/assets/{{$theme}}/plugins/sweet-alert/sweetalert2.all.min.js"></script>

		<!-- Select2 -->
		<script src="/assets/{{$theme}}/plugins/select2/select2.full.min.js"></script>

		<!-- accordion  -->
		<script src="/assets/{{$theme}}/plugins/accordion/accordion.min.js"></script>

		<!-- date-picker  -->
		<script src="/assets/{{$theme}}/plugins/date-picker/jquery-ui.js"></script>

		<!-- ckeditor -->
		<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>

		<!-- custom js -->
		<script src="/assets/{{$theme}}/js/custom.js"></script>

		<!-- nested sortable -->
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="/assets/generale/jquery.mjs.nestedSortable.js"></script>

		<script src="/assets/generale/didactic.js"></script>
		<script src="/assets/generale/webis.js"></script>
		@stack('javascript')
	</body>
</html>
