<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Administrator - @if($title){{$title}} @else {{ AdminHelper::getAppName() }} @endif</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.ico') }}"/>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link href="{{ asset('css/admin/plugins/Ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <!-- icheck bootstrap -->
    <link href="{{ asset('css/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet">
    <!-- Theme style -->
    <link href="{{ asset('css/admin/dist/css/adminlte.min.css') }}" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('js/admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/admin/jquery.validate.min.js') }}"></script>

    <!-- Toastr css -->
    @toastr_css

    <link href="{{ asset('css/admin/development.css') }}" rel="stylesheet">

</head>
<body class="hold-transition login-page text-sm background-styles">

    @include('admin.includes.notification')
    
    <div class="login-box">        
        <div class="card">
            <div class="login-logo">
                <a href="javascript: void(0);">
                    <img src="{{asset('images/admin/logo.png')}}" class="logo-car">
                </a>
            </div>              
            <div class="card-body login-card-body">
            @if (Route::currentRouteName() == 'admin.login')
                <p class="login-box-msg">@lang('custom_admin.label_login_text')</p>
            @endif
                
                @yield('content')
                
            </div>        
        </div>
    </div>

    <div id="loading">
        <img id="loading-image" src="{{asset('images/admin/'.AdminHelper::LOADER)}}" alt="">
    </div>
    
    <!-- Bootstrap 4 -->
    <script src="{{ asset('js/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('js/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('js/admin/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('js/admin/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/admin/dist/js/adminlte.min.js') }}"></script>
    
    <!-- Toastr js & rendering -->
    @toastr_js
    @toastr_render
    
    <script src="{{ asset('js/admin/development.js') }}"></script>
    <!-- Loader script -->
    {{-- <script type="text/javascript">
    $(document).ready(function() {
        $('.btn-loader').addClass('');
    });
    </script> --}}
    
</body>
</html>