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
		
		<!-- Datatable Css -->
		<link href="/assets/{{$theme}}/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />

		<link href="/assets/generale/admin.css" rel="stylesheet" />
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
								@if(isset($utilizator) && !$utilizator->admin)
									<div class="dropdown d-none d-md-flex">
										<a class="nav-link icon" data-toggle="dropdown">
											<i class="fas fa-bell"></i>
											@if(count($notificariNecitite))
												<span class="nav-unread bg-danger"></span>
											@endif
										</a>
										<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
											@foreach($notificariNecitite as $index=>$notificare_utilizator)
												<?php
												if($index>2){continue;}
												?>
												<a class="dropdown-item d-flex pb-3" href="#">
													<div>
														<strong><?=$notificare_utilizator->notificare->titlu_notificare?></strong>
														<div class="small text-muted">
															{{date('d-m-Y H:i:s', strtotime($notificare_utilizator->notificare->created_at))}}
														</div>
													</div>
												</a>
											@endforeach
											<div class="dropdown-divider"></div>
											<a class="dropdown-item text-center" href="/admin/notificari-utilizator">Vezi toate notificarile</a>
										
										</div>
									</div>
								@endif
								<div class="dropdown">
									<a class="nav-link pr-0 leading-none d-flex" data-toggle="dropdown" href="#">
										<span class="avatar avatar-md brround" style="background-image: url(<?=($utilizator->avatar?'/uploads/img_utilizatori/small/'.$utilizator->avatar:'/imagini/no-avatar.png')?>)"></span>
										<span class="ml-2 d-none d-lg-block">
											<span class="text-white">{{$utilizator->nume_utilizator ? $utilizator->nume_utilizator." ".$utilizator->prenume_utilizator: 'Webis'}}</span>
										</span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
									<a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="dropdown-icon mdi mdi-logout-variant"></i>Logout</a>
									<form action="{{ route('admin.logout') }}" id="logout-form" method="post">@csrf</form>
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
								<span class="avatar avatar-md brround" style="background-image: url(<?=($utilizator->avatar?'/uploads/img_utilizatori/small/'.$utilizator->avatar:'/imagini/no-avatar.png')?>)"></span>
								<span class="ml-2 "><span class=" app-sidebar__user-name font-weight-semibold">{{$utilizator->nume_utilizator ? $utilizator->nume_utilizator." ".$utilizator->prenume_utilizator: 'Webis'}}</span><br>
									<span class="text-muted app-sidebar__user-name text-sm"> {{$utilizator->email_utilizator ? $utilizator->email_utilizator: 'Webis'}}</span>
								</span>
							</a>
						</div>
					</div>
					<ul class="side-menu">
						@if(isset($elemente_meniu))
							<!-- meniu restrictionat pe roluri -->
							@foreach($elemente_meniu as $element_meniu)
								@if(!isset($element_meniu['subpagini']) || !count($element_meniu['subpagini']))
									<li>
										<a <?=(isLinkExtern($element_meniu['link_meniu'])?'target="_blank"':'')?> class="side-menu__item <?=(isset($pagina) && $pagina==$element_meniu['tip']?'active':'')?>" href="<?=$element_meniu['link_meniu']?>"><i class="side-menu__icon <?=getIconMeniu($element_meniu['tip'])?>"></i><span class="side-menu__label"><?=$element_meniu['eticheta_meniu']?></span></a>
									</li>
								@else
								@if(isset($element_meniu['subpagini']))
									<li class="slide">
										<a href="#" class="side-menu__item" data-toggle="slide">
											<i class="side-menu__icon fas fa-caret-square-down"></i>
											<span class="side-menu__label"><?=$element_meniu['eticheta_meniu']?></span>
											<i class="angle fas fa-angle-right"></i>
										</a>
										<ul class="slide-menu">
											<?php $subpagini=$element_meniu['subpagini']; ?>
											@foreach($subpagini as $subpagina)
												<li>
													<a <?=(isLinkExtern($subpagina['link_meniu'])?'target="_blank"':'')?> class="slide-item <?=(isset($pagina) && $pagina==$subpagina['tip']?'active':'')?>" href="<?=$subpagina['link_meniu']?>"><?=$subpagina['eticheta_meniu']?></a>
												</li>
											@endforeach
										</ul>
									</li>
								@endif
								@endif
							@endforeach
						@else
							<!-- meniu admin -->
							<li>
								<a class="side-menu__item" href="/admin"><i class="side-menu__icon fas fa-home"></i><span class="side-menu__label">Acasa</span></a>
							</li>
							<li>
								<a class="side-menu__item " href="{{env('APP_URL')}}/admin/pagini" ><i class="side-menu__icon fas fa-file"></i><span class="side-menu__label">Pagini</span></a>
							</li>
							<li>
								<a class="side-menu__item <?=(isset($pagina) && $pagina=='admini'?'active':'')?>" href="/admin/utilizatori"><i class="side-menu__icon fas fa-user"></i><span class="side-menu__label">Utilizatori</span></a>
							</li>
							<li>
								<a class="side-menu__item <?=(isset($pagina) && $pagina=='meniuri'?'active':'')?>" href="/admin/meniuri"><i class="side-menu__icon fas fa-bars"></i><span class="side-menu__label">Meniuri</span></a>
							</li>
							<li>
								<a class="side-menu__item <?=(isset($pagina) && $pagina=='loguri'?'active':'')?>" href="/admin/loguri"><i class="side-menu__icon fas fa-history"></i><span class="side-menu__label">Loguri</span></a>
							</li>
							<li>
								<a class="side-menu__item <?=(isset($pagina) && $pagina=='roluri'?'active':'')?>" href="/admin/roluri"><i class="side-menu__icon fas fa-user-tag"></i><span class="side-menu__label">Roluri</span></a>
							</li>
							<li>
								<a class="side-menu__item <?=(isset($pagina) && $pagina=='notificari'?'active':'')?>" href="/admin/notificari"><i class="side-menu__icon fas fa-bell"></i><span class="side-menu__label">Notificari</span></a>
							</li>
							<li>
								<a class="side-menu__item <?=(isset($pagina) && $pagina=='proiecte'?'active':'')?>" href="/admin/proiecte"><i class="side-menu__icon fas fa-project-diagram"></i><span class="side-menu__label">Proiecte</span></a>
							</li>
							<li>
								<a class="side-menu__item <?=(isset($pagina) && $pagina=='cadre-didactice'?'active':'')?>" href="/admin/cadre-didactice"><i class="side-menu__icon fa fa-graduation-cap" aria-hidden="true"></i><span class="side-menu__label">Cadre didactice</span></a>
							</li>
							<li>
								<a class="side-menu__item <?=(isset($pagina) && $pagina=='granturi'?'active':'')?>" href="/admin/granturi"><i class="side-menu__icon fas fa-file-alt" aria-hidden="true"></i><span class="side-menu__label">Granturi</span></a>
							</li>
							<li>
								<a class="side-menu__item <?=(isset($pagina) && $pagina=='granturi-cereri'?'active':'')?>" href="/admin/granturi-cereri"><i class="side-menu__icon fas fa-file-alt" aria-hidden="true"></i><span class="side-menu__label">Granturi cereri</span></a>
							</li>
							<li class="slide">
								<a href="#" class="side-menu__item" data-toggle="slide">
									<i class="side-menu__icon fas fa-chart-bar"></i>
									<span class="side-menu__label">Nomenclatoare</span>
									<i class="angle fas fa-angle-right"></i>
								</a>
								<ul class="slide-menu">
									<li>
										<a class="slide-item <?=(isset($pagina) && $pagina=='universitati'?'active':'')?>" href="/admin/universitati">Universitati</a>
									</li>
									<li>
										<a class="slide-item <?=(isset($pagina) && $pagina=='facultati'?'active':'')?>" href="/admin/facultati">Facultati</a>
									</li>
									<li>
										<a class="slide-item <?=(isset($pagina) && $pagina=='departamente'?'active':'')?>" href="/admin/departamente">Departamente</a>
									</li>
                                    <li>
										<a class="slide-item <?=(isset($pagina) && $pagina=='functii'?'active':'')?>" href="/admin/functii">Functii</a>
									</li>
                                    <li>
										<a class="slide-item <?=(isset($pagina) && $pagina=='tipuri-proiecte'?'active':'')?>" href="/admin/tipuri-proiecte">Tipuri proiecte</a>
									</li>
                                    <li>
										<a class="slide-item <?=(isset($pagina) && $pagina=='proiecte-categorii-cheltuieli'?'active':'')?>" href="/admin/categorii-cheltuieli">Categorii cheltuieli</a>
									</li>
                  					<li>
										<a class="slide-item <?=(isset($pagina) && $pagina=='valutar'?'active':'')?>" href="/admin/cursuri-valutare">Cursuri valutare</a>
									</li>
									<li>
										<a class="slide-item <?=(isset($pagina) && $pagina=='granturi-clasificari'?'active':'')?>" href="/admin/granturi-clasificari">Granturi clasificari</a>
									</li>
								</ul>
							</li>
						@endif
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

		<script src="/assets/generale/proiecte.js"></script>
		<script src="/assets/generale/granturi.js"></script>
		<script src="/assets/generale/webis.js"></script>
		@stack('javascript')
	</body>
</html>
