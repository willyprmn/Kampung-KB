<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="generator" content="Codeply">

    <title>@yield('title', 'Laporan Statistik Kampung KB')</title>
    <meta name="description" content="@yield('description', 'Pemaparan Data Statistik Kampung KB Seluruh Indonesia.')" itemprop="description" />
    <link rel="canonical" href="@yield('canonical', url()->current())" />

    @stack('analytics')
  <base target="_self">
  <!-- Scripts -->
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

  <link href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('bootstrap4/bootstrap.min.css') }}" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" type="text/css">
  <link href="{{ asset('bootstrap4/docs.css') }}" rel="stylesheet">

    @stack('styles')
    <style>

       li.statistik__menu {
            padding: 8px 4px 6px 32px;
            border-left: 4px solid transparent;
            color: #666666;
            font-size: 17px;
            line-height: 20px;
        }
        .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
        }
        .bg-white{
            background-color: transparent!important;
        }
    </style>
</head>
<body>

    <header class="flex-column flex-md-row">
        @include('portal.include.navbar')
    </header>
    <div class="container-fluid">
      <div class="row flex-xl-nowrap flex-md-wrap">
        <div class="col-md-3 col-xl-2 bd-sidebar">
            <form role="search" class="bd-search d-flex align-items-center">
                <h5 style="padding-left:10px;">Kampung KB</h5>
                <button class="btn bd-search-docs-toggle d-md-none p-0 ml-3" type="button" data-toggle="collapse" data-target="#bd-docs-nav" aria-controls="bd-docs-nav" aria-expanded="false" aria-label="Toggle docs navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img" focusable="false"><title>Menu</title><path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"/></svg>
                </button>
            </form>

            <x-sidebar-statistic/>
        </div>

        <main class="col-md-9 col-xl-10 py-md-3 pl-md-5 bd-content" role="main">
            @yield('content')
        </main>
      </div>
    </div>

    @stack('scripts')
    <script src="{{ asset('bootstrap4/bootstrap.bundle.min.js') }}" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="{{ asset('bootstrap4/docs.min.js') }}"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</body>
</html>