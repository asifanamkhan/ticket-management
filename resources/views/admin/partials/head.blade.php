<!DOCTYPE html>
<html lang="en" class="{{ session()->get('theme_mode') ?? 'light'  }}">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="{{ asset('dist/images/logo.svg') }}" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Icewall admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Icewall Admin Template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="LEFT4CODE">
        <!-- CSRF token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Autoville - Dashboard</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />

        @yield('css')
        <!-- END: CSS Assets-->

        <style>
            .custom-breadcrumb {
                margin-left: 0;
                border-left: 0;
                padding-left: 0;
            }
            .custom-breadcrumb .breadcrumb-link {
                color: #142E72;
                font-weight: bold;
            }
            .custom-breadcrumb .breadcrumb__icon {
                color: #142E72;
            }
            .custom-breadcrumb .breadcrumb--active {
                color: #142E72;
                font-weight: 400;
            }
        </style>

        @stack('styles')
    </head>