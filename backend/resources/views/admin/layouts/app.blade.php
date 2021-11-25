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
    <link rel="stylesheet" href="{{ asset('css/admin/plugins/fontawesome/css/font-awesome.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('css/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    @if (strpos(Route::currentRouteName(), '.gallery') !== false)
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="{{ asset('css/admin/plugins/ekko-lightbox/ekko-lightbox.css') }}">
    @endif

    <!-- Ionicons -->
    {{-- <link href="{{ asset('css/admin/plugins/Ionicons/css/ionicons.min.css') }}" rel="stylesheet"> --}}
    <!-- icheck bootstrap -->
    <link href="{{ asset('css/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('css/admin/plugins/select2/css/select2.min.css') }}">

    @if (strpos(Route::currentRouteName(), '.list') !== false)
    <!-- DataTables -->
    <link href="{{ asset('css/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    @endif

    <!-- Theme style -->
    <link href="{{ asset('css/admin/dist/css/adminlte.min.css') }}" rel="stylesheet">
    <!-- Pace style -->
    <link rel="stylesheet" href="{{ asset('css/admin/plugins/PACE/themes/blue/pace-theme-minimal.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- jQuery 3.4.1 -->
    <script src="{{ asset('js/admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/admin/jquery.validate.min.js') }}"></script>

    <!-- Sweet alert -->
    <link href="{{ asset('css/admin/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <!-- Toastr css -->
    <link href="{{ asset('css/admin/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/development.css') }}" rel="stylesheet">
</head>

@include('admin.includes.notification')

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed text-sm">
    
    <div class="wrapper">

        <!-- Navbar -->
        @include('admin.includes.header')
        <!-- /.navbar -->

        <!-- Sidebar  -->
        @include('admin.includes.sidebar')
        <!-- /.sidebar -->  

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->  

        <!-- Main Footer -->
        @include('admin.includes.footer')

    </div>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('js/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('js/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('js/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- PACE -->
    <script src="{{ asset('js/admin/plugins/PACE/pace.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('js/admin/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('js/admin/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    @if (strpos(Route::currentRouteName(), '.gallery') !== false)
    <!-- Ekko Lightbox -->
    <script src="{{ asset('js/admin/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
    });
    </script>
    @endif

    @if (strpos(Route::currentRouteName(), '.list') !== false)
    <!-- DataTables -->
    <script src="{{ asset('js/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
    $(function () {
        $('#list-data').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
    </script>
    @endif
    
    <!-- AdminLTE App -->
    <script src="{{ asset('js/admin/dist/js/adminlte.min.js') }}"></script>

    @if (Route::currentRouteName() == 'admin.dashboard')
    <!-- jQuery Mapael -->
    <script src="{{ asset('js/admin/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('js/admin/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('js/admin/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
    <script src="{{ asset('js/admin/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
    <script src="{{ asset('js/admin/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/admin/dist/js/pages/dashboard2.js') }}"></script>
    @endif

    @if (strpos(Route::currentRouteName(), '.add') !== false || strpos(Route::currentRouteName(), '.edit') !== false || (Route::currentRouteName() == 'admin.request-quote.list'))
    <script src="{{ asset('js/admin/plugins/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
    $(function () {
        try {
            if ($('#description').length) {
                CKEDITOR.replace('description', {
                    filebrowserUploadUrl: "{{route('admin.ckeditor-upload', ['_token' => csrf_token() ])}}",
                    filebrowserUploadMethod: 'form'
                });
            }
            if ($('#short_description').length) {
                CKEDITOR.replace('short_description', {
                    filebrowserUploadUrl: "{{route('admin.ckeditor-upload', ['_token' => csrf_token() ])}}",
                    filebrowserUploadMethod: 'form'
                });
            }
            if ($('#description2').length) {
                CKEDITOR.replace('description2', {
                    filebrowserUploadUrl: "{{route('admin.ckeditor-upload', ['_token' => csrf_token() ])}}",
                    filebrowserUploadMethod: 'form'
                });
            }
        } catch {

        }
    });
    </script>
    <!-- Cropper -->
    <link href="{{ asset('css/admin/plugins/croppie/croppie.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/admin/plugins/croppie/croppie.js') }}"></script>
    @endif
    
    <!-- Sweet alert -->
    <script src="{{ asset('css/admin/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <!-- Toastr js & rendering -->
    <script src="{{ asset('js/admin/plugins/toastr/toastr.min.js') }}"></script>
    @toastr_render

    <!-- AdminLTE App -->
    <script src="{{ asset('js/admin/development.js') }}"></script>    
    <script type="text/javascript">    
    $(function () {
        $('.select2').select2();
    });
    $(document).ajaxStart(function() {
        // To make Pace works on Ajax calls
        // $(document).ajaxStart(function () {
        //     Pace.restart();
        // });
    });
    </script>

    @if (strpos(Route::currentRouteName(), '.sort') !== false)
    <link href="{{ asset('css/admin/plugins/nestable/nestable.css') }}" rel="stylesheet">
    <script src="{{ asset('js/admin/plugins/nestable/jquery.nestable.js') }}"></script>
    @endif

    @stack('scripts')
    
</body>
</html>