<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ Illuminate\Support\Facades\App::currentLocale() == 'ar' ? 'rtl' : 'ltr' }}"
    class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="{{ asset('assets') . '/' }}"
    data-base-url="{{ url('/') }}" data-framework="laravel" data-template="vertical-menu-laravel-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title') | {{ config('app.name') }} </title>
    <!-- laravel CRUD token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link href="{{ asset('assets/img/favicon/apple-touch-icon.png') }}" rel="apple-touch-icon" sizes="180x180">
    <link type="image/png" href="{{ asset('assets/img/favicon/favicon-32x32.png') }}" rel="icon" sizes="32x32">
    <link type="image/png" href="{{ asset('assets/img/favicon/favicon-16x16.png') }}" rel="icon" sizes="16x16">
    <link href="{{ asset('assets/img/favicon/site.webmanifest') }}" rel="manifest">
    <link href="{{ asset('assets/img/favicon/safari-pinned-tab.svg') }}" rel="mask-icon" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#00aba9">
    <meta name="theme-color" content="#ffffff">

    <!-- Include Styles -->
    @include('layouts/sections/styles')

    <!-- Include Scripts for customizer, helper, analytics, config -->
    @include('layouts/sections/scriptsIncludes')
    @stack('styles')
</head>

<body>


    <!-- Layout Content -->
    @yield('layoutContent')
    <!--/ Layout Content -->
    <div id="myContent">

    </div>



    <!-- Include Scripts -->
    @include('layouts/sections/scripts')

    @stack('scripts')
</body>

</html>
