<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Scripts -->
        <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
        <!-- overlayScrollbars -->
        <link href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}" rel="stylesheet">

        @stack('styles')

        <!-- Theme style -->
        <link href="{{ asset('dist/css/adminlte.min.css') }}" rel="stylesheet">

    </head>
    <body style="background-color:white;" class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div id="app">

            <div class="wrapper">

                @include('admin.include.navbar')

                <x-sidebar />

                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <div class="content-header">
                        @yield('content-header')
                    </div>
                    <!-- /.content-header -->

                    <section class="container">

                        @if ($errors->any())
                            <x-alert :alert="[
                                'variant' => 'danger',
                                'title' => 'Validasi gagal',
                                'message' => 'Terjadi kesalahan pada pengisian, harap diisi sesuai dengan ketentuan pengisiaan'
                            ]" />

                            @if(config('app.env') !== 'production')
                                @dump($errors->toArray())
                            @endif
                        @endif

                        @if(session()->has('alert') && $alert = session()->get('alert'))
                            <x-alert :alert="$alert" />
                        @endif
                </section>
                <!-- Main content -->
                <section class="content">
                    @yield('content')
                </section>

                </div>
            </div>

        </div>


        <!-- REQUIRED SCRIPTS -->
        <!-- Bootstrap -->
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- overlayScrollbars -->
        <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('dist/js/adminlte.js') }}"></script>

        @stack('scripts')

        <script src="{{ mix('js/manifest.js') }}"></script>
        <script src="{{ mix('js/vendor.js') }}"></script>
        <script src="{{ mix('js/app.js') }}"></script>
        <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

    </body>
</html>
