<!DOCTYPE html>
<html lang="{{  app()->getLocale() }}" data-controller="html-load">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <title>
        @yield('title', config('app.name'))
        @hasSection('title')
            - {{ config('app.name') }}
        @endif
    </title>
    <meta name="csrf_token" content="{{  csrf_token() }}" id="csrf_token">
    <meta name="auth" content="{{  Auth::check() }}" id="auth">
    <link rel="stylesheet" type="text/css" href="{{  asset('vendor/orchid/css/orchid.css' ) }}">

    @stack('head')

    <meta name="turbo-root" content="{{  Dashboard::prefix() }}">
    <meta name="dashboard-prefix" content="{{  Dashboard::prefix() }}">

    @if(!config('platform.turbo.cache', false))
        <meta name="turbo-cache-control" content="no-cache">
    @endif

    <script src="{{ asset('vendor/orchid/js/manifest.js' ) }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/orchid/js/vendor.js' ) }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/orchid/js/orchid.js' ) }}" type="text/javascript"></script>

    @foreach(Dashboard::getResource('stylesheets') as $stylesheet)
        <link rel="stylesheet" href="{{  $stylesheet }}">
    @endforeach

    @stack('stylesheets')

    @foreach(Dashboard::getResource('scripts') as $scripts)
        <script src="{{  $scripts }}" defer type="text/javascript"></script>
    @endforeach
</head>

<body class="{{ \Orchid\Support\Names::getPageNameClass() }}">

<div class="container-fluid" data-controller="@yield('controller')" @yield('controller-data')>

    <div class="row">
        @yield('body-left')

        <div class="col min-vh-100 overflow-hidden">
            <div class="d-flex flex-column-fluid">
                <div class="container-md h-full px-0 px-md-5">
                    @yield('body-right')
                </div>
            </div>
        </div>
    </div>


    @include('platform::partials.toast')
</div>

@stack('scripts')


</body>
</html>
