<!DOCTYPE html>
<!--
Template Name: Icewall - HTML Admin Dashboard Template
Author: Left4code
Website: http://www.left4code.com/
Contact: muhammadrizki@left4code.com
Purchase: https://themeforest.net/user/left4code/portfolio
Renew Support: https://themeforest.net/user/left4code/portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en" class="light">
<!-- BEGIN: Head -->
<head>
    <meta charset="utf-8">
    <link href="{{ asset('dist/images/logo.svg') }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Icewall admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Icewall Admin Template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="LEFT4CODE">
    <title>Autovilla</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
    @yield('css')
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->
<body class="main">

<!-- END: Mobile Menu -->
<!-- BEGIN: Top Bar -->
<div class="top-bar-boxed border-b border-theme-2 -mt-7 md:-mt-5 -mx-3 sm:-mx-8 px-3 sm:px-8 md:pt-0 mb-12">
    <div class="h-full flex items-center">
        <!-- BEGIN: Logo -->
        <a class="-intro-x hidden md:flex" href="{{ url('/') }}">
            <span class="text-white text-lg ml-3"> {{ config('app.name', 'Laravel') }}</span>
        </a>
        <!-- END: Logo -->
        <!-- BEGIN: Breadcrumb -->
        <div class="-intro-x breadcrumb mr-auto"> <a href="">Profile</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Edit</a> </div>
        <!-- END: Breadcrumb -->
        <!-- BEGIN: Search -->
        <div class="intro-x relative mr-3 sm:mr-6">
            <div class="search hidden sm:block">
                <input type="text" class="search__input form-control dark:bg-dark-1 border-transparent placeholder-theme-8" placeholder="Search...">
                <i data-feather="search" class="search__icon dark:text-gray-300"></i>
            </div>
            <a class="notification sm:hidden" href=""> <i data-feather="search" class="notification__icon dark:text-gray-300"></i> </a>
        </div>
        <!-- END: Search -->
        <!-- BEGIN: Notifications -->
        <div class="intro-x dropdown mr-4 sm:mr-6">
            <div class="dropdown-toggle notification notification--bullet cursor-pointer" role="button" aria-expanded="false"> <i data-feather="bell" class="notification__icon dark:text-gray-300"></i> </div>
            <div class="notification-content pt-2 dropdown-menu">
                <div class="notification-content__box dropdown-menu__content box dark:bg-dark-6">
                    <div class="notification-content__title">Notifications</div>
                    <div class="cursor-pointer relative flex items-center ">
                        <div class="w-12 h-12 flex-none image-fit mr-1">
                            <img alt="Icewall Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('dist/images/profile-9.jpg') }}">
                            <div class="w-3 h-3 bg-theme-10 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                        </div>
                        <div class="ml-2 overflow-hidden">
                            <div class="flex items-center">
                                <a href="javascript:;" class="font-medium truncate mr-5">Kate Winslet</a>
                                <div class="text-xs text-gray-500 ml-auto whitespace-nowrap">05:09 AM</div>
                            </div>
                            <div class="w-full truncate text-gray-600 mt-0.5">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 20</div>
                        </div>
                    </div>
                    <div class="cursor-pointer relative flex items-center mt-5">
                        <div class="w-12 h-12 flex-none image-fit mr-1">
                            <img alt="Icewall Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('dist/images/profile-4.jpg') }}">
                            <div class="w-3 h-3 bg-theme-10 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                        </div>
                        <div class="ml-2 overflow-hidden">
                            <div class="flex items-center">
                                <a href="javascript:;" class="font-medium truncate mr-5">Hugh Jackman</a>
                                <div class="text-xs text-gray-500 ml-auto whitespace-nowrap">01:10 PM</div>
                            </div>
                            <div class="w-full truncate text-gray-600 mt-0.5">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem </div>
                        </div>
                    </div>
                    <div class="cursor-pointer relative flex items-center mt-5">
                        <div class="w-12 h-12 flex-none image-fit mr-1">
                            <img alt="Icewall Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('dist/images/profile-10.jpg') }}">
                            <div class="w-3 h-3 bg-theme-10 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                        </div>
                        <div class="ml-2 overflow-hidden">
                            <div class="flex items-center">
                                <a href="javascript:;" class="font-medium truncate mr-5">Angelina Jolie</a>
                                <div class="text-xs text-gray-500 ml-auto whitespace-nowrap">03:20 PM</div>
                            </div>
                            <div class="w-full truncate text-gray-600 mt-0.5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#039;s standard dummy text ever since the 1500</div>
                        </div>
                    </div>
                    <div class="cursor-pointer relative flex items-center mt-5">
                        <div class="w-12 h-12 flex-none image-fit mr-1">
                            <img alt="Icewall Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('dist/images/profile-3.jpg') }}">
                            <div class="w-3 h-3 bg-theme-10 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                        </div>
                        <div class="ml-2 overflow-hidden">
                            <div class="flex items-center">
                                <a href="javascript:;" class="font-medium truncate mr-5">Russell Crowe</a>
                                <div class="text-xs text-gray-500 ml-auto whitespace-nowrap">01:10 PM</div>
                            </div>
                            <div class="w-full truncate text-gray-600 mt-0.5">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem </div>
                        </div>
                    </div>
                    <div class="cursor-pointer relative flex items-center mt-5">
                        <div class="w-12 h-12 flex-none image-fit mr-1">
                            <img alt="Icewall Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('dist/images/profile-10.jpg') }}">
                            <div class="w-3 h-3 bg-theme-10 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                        </div>
                        <div class="ml-2 overflow-hidden">
                            <div class="flex items-center">
                                <a href="javascript:;" class="font-medium truncate mr-5">Denzel Washington</a>
                                <div class="text-xs text-gray-500 ml-auto whitespace-nowrap">05:09 AM</div>
                            </div>
                            <div class="w-full truncate text-gray-600 mt-0.5">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Notifications -->
        <!-- BEGIN: Account Menu -->
        <div class="intro-x dropdown w-8 h-8">
            <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110" role="button" aria-expanded="false">
                <img alt="Icewall Tailwind HTML Admin Template" src="{{ asset('dist/images/profile-6.jpg') }}">
            </div>
            <div class="dropdown-menu w-56">
                <div class="dropdown-menu__content box bg-theme-11 dark:bg-dark-6 text-white">
                    <div class="p-4 border-b border-theme-12 dark:border-dark-3">
                        <div class="font-medium">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                        <div class="text-xs text-theme-13 mt-0.5 dark:text-gray-600">Visitor</div>
                    </div>
                    <div class="p-2">
                        <a href="{{ route('visitor.profile.edit', ['profile' => auth()->user()->id]) }}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="user" class="w-4 h-4 mr-2"></i> Profile </a>
                        <!-- <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="edit" class="w-4 h-4 mr-2"></i> Add Account </a> -->
                        <a href="{{ route('password.request') }}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Reset Password </a>
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="help-circle" class="w-4 h-4 mr-2"></i> Help </a>
                    </div>
                    <div class="p-2 border-t border-theme-12 dark:border-dark-3">
                        <a class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Account Menu -->
    </div>
</div>
<!-- END: Top Bar -->
<!-- BEGIN: Top Menu -->
<nav class="top-nav">
    <ul>
        <li>
            <a href="javascript:;" class="top-menu"></a>
        </li>
    </ul>
</nav>
<!-- END: Top Menu -->
<!-- BEGIN: Content -->
<div class="wrapper wrapper--top-nav">
    <div class="wrapper-box">
        <!-- BEGIN: Content -->
        <div class="content">
            <div class="intro-y flex items-center mt-8">
                <h2 class="text-lg font-medium mr-auto">
                    Update Profile
                </h2>
            </div>
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Profile Menu -->
                <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse">
                    <div class="intro-y box mt-5">
                        <div class="relative flex items-center p-5">
                            <div class="w-12 h-12 image-fit">
                                <img alt="Icewall Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('dist/images/profile-11.jpg') }}">
                            </div>
                            <div class="ml-4 mr-auto">
                                <div class="font-medium text-base">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                                <div class="text-gray-600">Visitor</div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"> <i data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-300"></i> </a>
                                <div class="dropdown-menu w-56">
                                    <div class="dropdown-menu__content box dark:bg-dark-1">
                                        <div class="p-4 border-b border-gray-200 dark:border-dark-5 font-medium">Export Options</div>
                                        <div class="p-2">
                                            <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="activity" class="w-4 h-4 text-gray-700 dark:text-gray-300 mr-2"></i> English </a>
                                            <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                <i data-feather="box" class="w-4 h-4 text-gray-700 dark:text-gray-300 mr-2"></i> Indonesia
                                                <div class="text-xs text-white px-1 rounded-full bg-theme-24 ml-auto">10</div>
                                            </a>
                                            <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="layout" class="w-4 h-4 text-gray-700 dark:text-gray-300 mr-2"></i> English </a>
                                            <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="sidebar" class="w-4 h-4 text-gray-700 dark:text-gray-300 mr-2"></i> Indonesia </a>
                                        </div>
                                        <div class="px-3 py-3 border-t border-gray-200 dark:border-dark-5 font-medium flex">
                                            <button type="button" class="btn btn-primary py-1 px-2">Settings</button>
                                            <button type="button" class="btn btn-secondary py-1 px-2 ml-auto">View Profile</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                            <a class="flex items-center {{ request()->is('profile*') ? 'text-theme-17 dark:text-gray-300 font-medium' : ''}}" href="{{route('visitor.profile.edit', ['profile' => auth()->user()->id])}}"> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Personal Information </a>
                            <a class="flex items-center mt-5 {{ request()->is('orders*') ? 'text-theme-17 dark:text-gray-300 font-medium' : '' }}" href="{{ route('visitor.orders.index') }}"> <i data-feather="box" class="w-4 h-4 mr-2"></i> Purchases </a>

                            <a class="flex items-center mt-5" href="{{ route('password.request') }}"> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Change Password </a>

                            <a class="flex items-center mt-5" href=""> <i data-feather="settings" class="w-4 h-4 mr-2"></i> User Settings </a>
                        </div>
                        <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                            <a class="flex items-center" href=""> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Email Settings </a>
                            <a class="flex items-center mt-5" href=""> <i data-feather="box" class="w-4 h-4 mr-2"></i> Saved Credit Cards </a>
                            <a class="flex items-center mt-5" href=""> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Social Networks </a>
                            <a class="flex items-center mt-5" href=""> <i data-feather="settings" class="w-4 h-4 mr-2"></i> Tax Information </a>
                        </div>
                        <!-- <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex">
                            <button type="button" class="btn btn-primary py-1 px-2">New Group</button>
                            <button type="button" class="btn btn-outline-secondary py-1 px-2 ml-auto">New Quick Link</button>
                        </div> -->
                    </div>
                </div>
                <!-- END: Profile Menu -->
                <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
                    <!-- BEGIN: Personal Information -->
                    <div class="intro-y box lg:mt-5">
                        @yield('content')
                    </div>
                    <!-- END: Personal Information -->
                </div>
            </div>
        </div>
        <!-- END: Content -->
    </div>
</div>
<!-- END: Content -->
<!-- END: Dark Mode Switcher-->
<script src="{{ asset('dist/js/app.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@yield('script')
<!-- END: JS Assets-->
</body>
</html>
