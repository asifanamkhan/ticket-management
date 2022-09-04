<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}}
        </style>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="{{ asset('css/package.css') }}" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
            ul {
                /* padding-left: 15px; */
            }
        </style>
    </head>
    <body class="antialiased">
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @if (Route::has('admin.dashboard'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                                </li>
                            @endif
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->first_name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a href="{{ route('visitor.profile.edit', ['profile' => auth()->user()->id]) }}" class="dropdown-item">Profile</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container mt-5" id="package-container">

                @php $cart = session()->has('cart') ? session()->get('cart') : null; @endphp
                <h2>Total: {{ $total }}</h2>
                <!-- Types -->
                @if(count($types) > 0)
                <div class="package-types">
                  <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        @foreach($types as $type)
                            <a 
                                class="nav-item nav-link {{ $loop->iteration == 1 ? 'active' : '' }}" 
                                id="nav-type-{{$loop->iteration}}-tab" 
                                data-toggle="tab" 
                                href="#nav-type-{{$loop->iteration}}" 
                                role="tab" 
                                aria-controls="nav-type-{{$loop->iteration}}" 
                                aria-selected="{{ $loop->iteration == 1 ? true : false }}">{{ $type->name}}</a>
                        @endforeach
                        </div>
                  </nav>
                  <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                    @foreach($types as $type)
                        <div class="tab-pane fade show {{  $loop->iteration === 1 ? 'active' : '' }}" id="nav-type-{{ $loop->iteration }}" role="tabpanel" aria-labelledby="nav-type-{{$loop->iteration}}-tab">
                        @if(count($type->days()) > 0)
                            <div id="accordion">
                                @foreach($type->days() as $day => $packages)
                                    <div class="card">
                                        <div class="card-header" id="day-heading-{{$loop->iteration}}">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#day-{{ $loop->iteration }}" aria-expanded="true" aria-controls="day-{{ $loop->iteration }}">
                                                {{ $day }}
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="day-{{ $loop->iteration }}" class="collapse {{ $loop->iteration == 1 ? 'show' : '' }}" aria-labelledby="day-heading-{{ $loop->iteration }}" data-parent="#accordion">
                                            <div class="card-body">
                                                @if(count($packages) > 0)
                                                <div id="{{ Str::slug(Str::lower($day)) }}">
                                                    
                                                    @foreach($packages as $package)
                                                        @php 
                                                            $cart_package_type = $cart[$type->id] ?? null;
                                                            
                                                            $cart_day = $cart_package_type ? $cart_package_type[Str::snake($day)] ?? null : null; 
                                                            $cart_package = $cart_day[$package->id] ?? null;
                                                        @endphp
                                                        <div class="card">
                                                            <div class="card-header" id="package-heading-{{$loop->iteration}}">
                                                                <div class="mb-0">
                                                                    <button class="btn btn-link" data-toggle="collapse" data-target="#package-{{ $package->id }}" aria-expanded="true" aria-controls="package-{{ $loop->iteration }}">
                                                                    {{ $package->name }}
                                                                    </button>

                                                                    <span 
                                                                        class="add-to-cart-content"
                                                                        data-package-type-id="{{ $type->id }}"
                                                                        data-day="{{ Str::snake($day) }}"
                                                                        data-package-id="{{ $package->id }}"
                                                                    >
                                                                        <input type="hidden" name="price" class="price" value="{{ $package->price }}" />
                                                                        <input type="hidden" name="subtotal" class="subtotal" value="{{ $cart_package ? $cart_package['qty'] * $package->price : $package->price }}" />
                                                                        <span>Price: {{ $package->price }}</span>
                                                                        @php $cart_addons_price = 0; @endphp
                                                                        @if(isset($cart_package['activities']))
                                                                            @foreach($package->activities as $activity)
                                                                                @if(in_array($activity->id, $cart_package['activities']))
                                                                                    @php $cart_addons_price += $activity->price; @endphp
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                        <span class="subtotal-preview">Sub Total: {{  $cart_package ? $cart_addons_price + ($cart_package['qty'] * $package->price) : $package->price  }}</span>
                                                                        <input type="number" name="qty" class="qty" value="{{ $cart_package ? $cart_package['qty'] : 1 }}" />
                                                                        @if($cart_package)
                                                                        <button class="btn btn-success btn-lg disabled" disabled>Added to cart</button>
                                                                        @else
                                                                        <button class="btn btn-success btn-lg add-to-cart">Add to cart</button>
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div id="package-{{ $package->id }}" class="collapse" aria-labelledby="package-heading-{{ $loop->iteration }}" data-parent="#{{ Str::slug(Str::lower($day)) }}">
                                                                <div class="card-body">
                                                                    @if (count($package->activities) > 0)
                                                                        <div class="row">
                                                                            @forelse($package->activities as $activity)
                                                                                <div class="col-md-3">
                                                                                    @if(sizeof($activity->images) > 0)
                                                                                        <img src="{{ asset('uploads/activity/' . $activity->images[0]) }}" class="activity-image" alt="Activity image" />
                                                                                    @endif
                                                                                    <h3 class="activity-title">{{ $activity->name }}</h3>
                                                                                    @if($activity->price > 0)
                                                                                        @if(isset($cart_package['activities']) && in_array($activity->id, $cart_package['activities']))
                                                                                            <button class="btn btn-success btn-sm disabled" disabled>Added</button>
                                                                                        @else
                                                                                            <button 
                                                                                                class="btn btn-success btn-sm add-on" 
                                                                                                data-id="{{ $activity->id }}" 
                                                                                                data-price="{{ $activity->price }}">Add</button>
                                                                                        @endif
                                                                                    @endif
                                                                                </div>
                                                                            @empty
                                                                                <p>Sorry there is no activity.</p>
                                                                            @endforelse
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        </div>
                    @endforeach
                  </div>
                
                </div>
                @endif
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        <script src="{{ asset('js/cart.js') }}"></script>
    </body>
</html>
