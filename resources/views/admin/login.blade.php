<!DOCTYPE html>
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
   <link rel="icon" href="{{ asset('/assets/<?=$theme?>/images/brand/') }}" type="image/x-icon"/>
   <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/assets/<?=$theme?>/images/brand/') }}" />


   <!-- Title -->

   <title>Login</title>

   <!--Font Awesome-->
   <link href="{{env('APP_URL')}}/assets/<?=$theme?>/plugins/fontawesome-free/css/all.css" rel="stylesheet">

   <!--Date picker-->
   <link href="{{env('APP_URL')}}/assets/<?=$theme?>/plugins/date-picker/spectrum.css" rel="stylesheet">

   <!-- Font Family-->
   <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet">

   <!-- Dashboard Css -->
   <link href="{{env('APP_URL')}}/assets/<?=$theme?>/css/dashboard.css" rel="stylesheet" />

   <!-- Admin Css -->
   <link href="{{env('APP_URL')}}/assets/<?=$theme?>/css/admin.css" rel="stylesheet" />

   <!-- Custom scroll bar css-->
   <link href="{{env('APP_URL')}}/assets/<?=$theme?>/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />

   <!-- Sidemenu Css -->
   <link href="{{env('APP_URL')}}/assets/<?=$theme?>/plugins/toggle-sidebar/css/sidemenu.css" rel="stylesheet">

   <!-- c3.js Charts Plugin -->
   <link href="{{env('APP_URL')}}/assets/<?=$theme?>/plugins/charts-c3/c3-chart.css" rel="stylesheet" />

   <!---Font icons-->
   <link href="{{env('APP_URL')}}/assets/<?=$theme?>/plugins/iconfonts/plugin.css" rel="stylesheet" />

   {{-- Editor  --}}
   <link href="{{env('APP_URL')}}/assets/<?=$theme?>/plugins/wysiwyag/richtext.min.css" rel="stylesheet" />


</head>
<body class="login-img bg-gradient">
   <div id="app">
      <main class="py-4">
         <body class="login-img bg-gradient">
            <!-- Header Background Animation-->
            <div id="particles-js"  class=""></div>
            <div id="global-loader" ><div class="showbox"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div></div>
            <div class="page">
               <div class="page-single">
                  <div class="container">
                     <div class="row">
                        <div class="col col-login mx-auto" style = "margin-top: 100px;">
                           <div class="text-center mb-6">
                              <img src="{{env('APP_URL')}}/imagini/{{env('APP_LOGO')}}" class="h-7" alt="" style="width: 70%; height:70% !important">
                           </div>
                           <form class="card" action="{{ route('admin.check') }}" method="post">
                              @csrf
                              <div class="card-body p-6">
                                 <div class="card-title text-center">{{ __('Login') }}</div>
                                 @if (Session::get('fail'))
                                 <div class="alert alert-danger">
                                    {{ Session::get('fail') }}
                                 </div>
                                 @endif
                                 <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email_utilizator" placeholder="Email" value="{{ old('email_utilizator') }}">
                                    <span class="text-danger">@error('email_utilizator'){{ $message }}@enderror</span>
                                 </div>
                                 <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password" value="{{ old('password') }}">
                                    <span class="text-danger">@error('password'){{ $message }}@enderror</span>
                                 </div>
                                 <div class="form-group row">
                                    <div class="col-12">
                                       <div class="form-check">
                                          <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                          <label class="form-check-label" for="remember">
                                             {{ __('Remember Me') }}
                                          </label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-footer">
                                    <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </main>
      </div>


      <!-- Dashboard js -->
      <script src="{{env('APP_URL')}}/assets/<?=$theme?>/js/vendors/jquery-3.2.1.min.js"></script>
      <script src="{{env('APP_URL')}}/assets/<?=$theme?>/js/vendors/bootstrap.bundle.min.js"></script>
      <script src="{{env('APP_URL')}}/assets/<?=$theme?>/js/vendors/jquery.sparkline.min.js"></script>
      <script src="{{env('APP_URL')}}/assets/<?=$theme?>/js/vendors/selectize.min.js"></script>
      <script src="{{env('APP_URL')}}/assets/<?=$theme?>/js/vendors/jquery.tablesorter.min.js"></script>
      <script src="{{env('APP_URL')}}/assets/<?=$theme?>/js/vendors/circle-progress.min.js"></script>
      <script src="{{env('APP_URL')}}/assets/<?=$theme?>/plugins/rating/jquery.rating-stars.js"></script>
      <!-- Side menu js -->
      <script src="{{env('APP_URL')}}/assets/<?=$theme?>/plugins/toggle-sidebar/js/sidemenu.js"></script>

      <!-- Custom scroll bar Js-->
      <script src="{{env('APP_URL')}}/assets/<?=$theme?>/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

      <!-- animation -->
      <script src="{{env('APP_URL')}}/assets/<?=$theme?>/plugins/particles/particles.js"></script>
      <script src="{{env('APP_URL')}}/assets/<?=$theme?>/plugins/particles/particlesapp_default.js"></script>

      <!--Counters -->
      <script src="{{env('APP_URL')}}/assets/<?=$theme?>/plugins/counters/counterup.min.js"></script>
      <script src="{{env('APP_URL')}}/assets/<?=$theme?>/plugins/counters/waypoints.min.js"></script>

      <!-- Custom js -->
      <script src="{{env('APP_URL')}}/assets/<?=$theme?>/js/custom.js"></script>

      <!-- Data tables -->
      <script src="{{env('APP_URL')}}/assets/<?=$theme?>/plugins/datatable/jquery.dataTables.min.js"></script>
      <script src="{{env('APP_URL')}}/assets/<?=$theme?>/plugins/datatable/dataTables.bootstrap4.min.js"></script>

      <!-- WYSIWYG Editor js -->
      <script src="{{env('APP_URL')}}/assets/<?=$theme?>/plugins/wysiwyag/jquery.richtext.js"></script>

      <!-- datepicker -->
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


      {{-- Sweet Alert --}}
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


      <!-- Webis js -->
      <script src="{{env('APP_URL')}}/assets/<?=$theme?>/js/webis.js"></script>


      <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

      {!! $inapoi ?? '' !!}

   </body>
   </html>
