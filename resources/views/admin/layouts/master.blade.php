@include('admin.partials.head')
    <!-- END: Head -->
    <body class="main">
        <!-- BEGIN: Mobile Menu -->
        @include('admin.partials.mobile-menu')
        <!-- END: Mobile Menu -->
        <!-- BEGIN: Top Bar -->
        @include('admin.partials.top-bar')
        <!-- END: Top Bar -->
        <div class="wrapper">
            <div class="wrapper-box">
                <!-- BEGIN: Side Menu -->
                @include('admin.partials.sidebar-menu')
                <!-- END: Side Menu -->
                <!-- BEGIN: Content -->
                <div class="content">
                    @yield('content')
                </div>
                <!-- END: Content -->
            </div>
        </div>
        <!-- BEGIN: Dark Mode Switcher-->
        @include('admin.partials.theme-mode-switcher')
        <!-- END: Dark Mode Switcher-->
        <!-- BEGIN: JS Assets-->
        <!-- <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script> -->
        <!-- <script src="https://maps.googleapis.com/maps/api/js?key=['your-google-map-api']&libraries=places"></script> -->
        <script src="{{ asset('dist/js/app.js') }}"></script>
        <script src="{{asset('dist/js/ckeditor-classic.js')}}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

        @stack('scripts')

        <!-- END: JS Assets-->
    </body>
</html>