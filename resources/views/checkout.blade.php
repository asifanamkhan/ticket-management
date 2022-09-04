<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <style>
        /*.border-top{*/
        /*border:1px solid #edf2f7;*/

        /*}*/
    </style>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        ul {
            /* padding-left: 15px; */
        }
        .billing-title {
            font-size: 24px;
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
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
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
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->first_name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a href="{{ route('visitor.profile.edit', ['profile' => auth()->user()->id]) }}"
                                   class="dropdown-item">Profile</a>
                                   <a href="{{ route('visitor.orders.index') }}" class="dropdown-item"> Purchases </a>
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

    @if(Session::has('thankyou_message'))
        <div class="alert alert-success mt-4 container" role="alert">
            {{ Session::get('thankyou_message') }}
        </div>
    @endif

    @if(Session::has('package-quantity-check'))
        <div class="alert alert-success mt-4 container" role="alert">
            {{ Session::get('package-quantity-check') }}
        </div>
    @endif

    @if (cart_total() > 0)
        <form method="POST" action="{{ route('visitor.checkout') }}" class="mt-4 container" autocomplete="off">
            @csrf
        <div class="row">
            <div class="col-xl-8 col-md-7" id="accordion">
                <div class="row font-weight-bold border mb-2 " style="font-size: 20px">
                    <div class="col-md-3">
                        Package name
                    </div>
                    <div class="col-md-2">
                        Type
                    </div>
                    <div class="col-md-2">
                        Day
                    </div>
                    <div class="col-md-2">
                        Quantity
                    </div>
                    <div class="col-md-3">
                        Price
                    </div>
                </div>

                @if(count( $results) > 0)
                    @foreach($results as $packageType)
                        @if(count( $packageType->days) > 0)
                            @foreach($packageType->days as $day)
                                @if(count( $day->packages) > 0)
                                    @foreach($day->packages as $package)
                                        <input type="hidden" name="packages[{{ $package->id }}]" value="{{ $package->id }}">
                                        <div class="card mb-1">
                                            <div class="card-header" id="package-heading-{{$loop->iteration}}">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <a href="void:0" style="width: 100%; text-align: left"
                                                                class="btn btn-link"
                                                                data-toggle="collapse" aria-expanded="true"
                                                                data-target="#package-{{ $package->id}}"
                                                                aria-controls="package-{{ $loop->iteration }}">
                                                            {{ $package->name }}
                                                        </a>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div>
                                                            {{$packageType->name}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div>
                                                            {{$day->name}}
                                                        </div>
                                                    </div>
                                                    @if(isset($package->cart))
                                                        <input type="hidden" name="packages[{{ $package->id }}][qty]" value="{{ $package->cart['qty'] }}">
                                                        <input type="hidden" name="packages[{{ $package->id }}][price]" value="{{ $package->cart['price'] }}">
                                                        <input type="hidden" name="package_{{$package->id}}_qty" value="{{ $package->cart['qty'] }}">
                                                        <input type="hidden" name="package_{{$package->id}}_price" value="{{ $package->cart['price'] }}">
                                                        <div class="col-md-2">
                                                            <div>
                                                                {{$package->cart['qty']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div>
                                                                {{$package->cart['price']}}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div id="package-{{ $package->id }}" class="card-body collapse show"
                                             aria-labelledby="package-{{ $loop->iteration }}"
                                             data-parent="#{{ Str::slug(Str::lower($day->name)) }}">

                                            <div class="card-body">

                                                @if(isset($package->cart) && isset($package->cart['concerts']) && count( $package->cart['concerts']) > 0)
                                                    <div class="row font-weight-bold border mb-2"
                                                         style="font-size: 18px">
                                                        <div class="col-md-3 ">
                                                            Concert image
                                                        </div>
                                                        <div class="col-md-3">
                                                            Concert name
                                                        </div>
                                                        <div class="col-md-3">
                                                            Qty
                                                        </div>
                                                        <div class="col-md-3">
                                                            Concert price
                                                        </div>
                                                    </div>

                                                    @foreach($package->cart['concerts'] as $key => $concert)
                                                        @if($concert->qty < 1) @continue @endif
                                                        <input type="hidden" name="packages[{{ $package->id }}][concerts][id]" value="{{ $concert->id }}">
                                                        <div class="card mb-1">
                                                            <div class="card-header"
                                                                 id="concert-heading-{{$loop->iteration}}">
                                                                <h5 class="mb-0">
                                                                    <div class="row" style="font-size: 16px">
                                                                        <div class="col-md-3">
                                                                            <img style="max-height: 100px;max-width: 100px"
                                                                                 class="activity-image" alt="image"
                                                                                 @if(is_array($concert->images) && sizeof($concert->images) > 0)
                                                                                 src="{{ asset('uploads/activity/' . $concert->images[0]) }}"
                                                                                    @endif
                                                                            />
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            {{ $concert->name }}
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <input 
                                                                                type="number" 
                                                                                id="package_{{$package->id}}_concert_{{$concert->id}}" 
                                                                                value="{{$concert->qty}}" 
                                                                                class="concert-qty form-control" 
                                                                                data-package-type-id="{{ $packageType->id }}"
                                                                                data-package-id="{{ $package->id }}"
                                                                                data-day="{{ $day->name }}"
                                                                                data-package-price="0"
                                                                                data-qty="{{ $package->cart['qty'] }}"
                                                                                data-concert-id="{{ $concert->id }}"
                                                                                data-concert-price="{{ $concert->price }}"
                                                                                min = "1"
                                                                                data-concert="{{ isset($package->cart['join_concert']) && $package->cart['join_concert'] == 'true' }}"
                                                                            />
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            @if($concert->price > 0)
                                                                                <p>Price: {{ $concert->price }}</p>
                                                                            @else
                                                                                Free
                                                                            @endif
                                                                        </div>

                                                                    </div>
                                                                </h5>
                                                            </div>
                                                        </div>

                                                    @endforeach
                                                @endif

                                                @if(isset($package->cart) && isset($package->cart['activities']) && count( $package->cart['activities']) > 0)
                                                    <div class="row font-weight-bold border mb-2"
                                                         style="font-size: 18px">
                                                        <div class="col-md-3 ">
                                                            Add on image
                                                        </div>
                                                        <div class="col-md-3">
                                                            Add on name
                                                        </div>
                                                        <div class="col-md-3">
                                                            Qty
                                                        </div>
                                                        <div class="col-md-3">
                                                            Add on price
                                                        </div>
                                                    </div>

                                                    @foreach($package->cart['activities'] as $key => $activity)
                                                        @if($activity->qty < 1) @continue @endif
                                                        <input type="hidden" name="packages[{{ $package->id }}][activities][id]" value="{{ $activity->id }}">
                                                        <div class="card mb-1">
                                                            <div class="card-header"
                                                                 id="activity-heading-{{$loop->iteration}}">
                                                                <h5 class="mb-0">
                                                                    <div class="row" style="font-size: 16px">
                                                                        <div class="col-md-3">
                                                                            <img style="max-height: 100px;max-width: 100px"
                                                                                 class="activity-image" alt="image"
                                                                                 @if(is_array($activity->images) && sizeof($activity->images) > 0)
                                                                                 src="{{ asset('uploads/activity/' . $activity->images[0]) }}"
                                                                                    @endif
                                                                            />
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            {{ $activity->name }}
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <input 
                                                                                type="number" 
                                                                                id="package_{{$package->id}}_activity_{{$activity->id}}" 
                                                                                value="{{$activity->qty}}" 
                                                                                class="activity-qty form-control" 
                                                                                data-package-type-id="{{ $packageType->id }}"
                                                                                data-package-id="{{ $package->id }}"
                                                                                data-day="{{ $day->name }}"
                                                                                data-price="{{ $package->price }}"
                                                                                data-qty="{{ $package->cart['qty'] }}"
                                                                                data-addon-id="{{ $activity->id }}"
                                                                                data-addon-price="{{ $activity->price }}"
                                                                                min = "1"
                                                                            />
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            @if($activity->price > 0)
                                                                                <p>Price: {{ $activity->price }}</p>
                                                                            @else
                                                                                Free
                                                                            @endif
                                                                        </div>

                                                                    </div>
                                                                </h5>
                                                            </div>
                                                        </div>

                                                    @endforeach
                                                @endif

                                                @if($package->cart['qty'] > 1)
                                                    <div class="alert alert-danger" role="alert">
                                                        <small>
                                                            You have added more then 1 "{{ $package->name }}" - package.
                                                            So you need to provide {{ $package->cart['qty'] -1 }} more
                                                            names.
                                                        </small>
                                                    </div>
                                                    @for($i=1; $i < $package->cart['qty']; $i++)
                                                        @php $name = "package_{$package->id}_name_{$i}" @endphp
                                                        <div class="form-group row">
                                                            <small class="col-md-3 text-md-right">Name {{ $i}}:</small>
                                                            <input 
                                                                type="text" 
                                                                name="{{$name}}" 
                                                                value="{{ old($name) }}" 
                                                                class="form-control col-md-6 @error($name) is-invalid @enderror">
                                                            @error($name)
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    @endfor
                                                @endif

                                            </div>
                                        </div>

                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="col-xl-4 col-md-5">
                <div class="row justify-content-center">
                    @php
                        $vat = cart_total() - (cart_total() / 1.15);
                    @endphp

                    <p class="font-weight-bold m-0 col-12 text-center">Vat 15%:  <span id="vat-amount">{{ number_format($vat, 2) }}</span> SAR</p>
                    <p class="font-weight-bold m-0 col-12 text-center">Sub Total:  <span id="sub-total">{{ number_format(cart_total() - $vat, 2) }}</span> SAR</p>
                    <p class="font-weight-bold m-0 col-12 text-center">Total:  <span id="total">{{ number_format(cart_total(), 2) }}</span> SAR</p>
                    <div class="col-md-10">
                        <h2 class="mt-3 billing-title">Billing Details</h2>

                        <div class="customer_details" id="customer_details">

                            <div class="form-group m-0">
                                <label for="customer_name"
                                    class="col-form-label text-md-right">{{ __('Name') }}</label>
                                <input 
                                    id="customer_name" 
                                    type="text"
                                    class="form-control @error('customer_name') is-invalid @enderror" 
                                    name="customer_name"
                                    value="{{ old('customer_name') ? old('customer_name') : (auth()->check() ? auth()->user()->first_name . auth()->user()->last_name: '') }}" autocomplete="customer_name">

                                @error('customer_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group m-0">
                                <label for="customer_email"
                                    class="col-form-label text-md-right">{{ __('E-Mail') }}</label>

                                <input id="customer_email" type="email"
                                    class="form-control disabled @error('customer_email') is-invalid @enderror"
                                    name="customer_email" value="{{ old('customer_email') ? old('customer_email') : (auth()->check() ? auth()->user()->email : '') }}" disabled autocomplete="email">

                                @error('customer_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group m-0">
                                <label for="customer_address"
                                    class="col-form-label text-md-right">{{ __('Address') }}</label>

                                <input id="customer_address" type="text"
                                    class="form-control @error('customer_address') is-invalid @enderror" name="customer_address"
                                    value="{{ old('customer_address') ? old('customer_address') : (auth()->check() ? auth()->user()->address : '') }}" autocomplete="customer_address">

                                @error('customer_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group m-0">
                                <label for="customer_phone"
                                    class="col-form-label text-md-right">{{ __('Phone') }}</label>
                                <input id="customer_phone" type="number"
                                    class="form-control @error('customer_phone') is-invalid @enderror" name="customer_phone"
                                    value="{{ old('customer_phone') ? old('customer_phone') : (auth()->check() ? auth()->user()->mobile : '')  }}" autocomplete="customer_phone">

                                @error('customer_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group m-0">
                                <label for="customer_country_id"
                                    class="col-form-label text-md-right">{{ __('Country') }}</label>

                                    <select name="customer_country_id" id="customer_country_id" class="form-control @error('customer_country_id') is-invalid @enderror" autocomplete="customer_country_id">
                                        <option value="">Select a country</option>
                                        @foreach(countries() as $country) 
                                            <option 
                                                value="{{ $country->id }}" 
                                                {{ 
                                                    old('customer_country_id') ? 
                                                    (old('customer_country_id') == $country->id ? 'selected' : '') : 
                                                    (
                                                        auth()->check() && auth()->user()->country_id == $country->id ?
                                                         'selected' : 
                                                         ''
                                                    ) 
                                                }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                @error('customer_country_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group m-0">
                                <label for="customer_state"
                                    class="col-form-label text-md-right">{{ __('State') }}</label>

                                <input type="text" name="customer_state" id="" class="form-control @error('customer_state') is-invalid @enderror" autocomplete="customer_state"
                                value="{{ old('customer_state') ? old('customer_state') : (auth()->check() ? auth()->user()->state : '')  }}">
                                @error('customer_state')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group m-0">
                                <label for="customer_city"
                                    class="col-form-label text-md-right">{{ __('City') }}</label>

                                <input 
                                    type="text" 
                                    name="customer_city" 
                                    id="" 
                                    class="form-control @error('customer_city') is-invalid @enderror" 
                                    value="{{ old('customer_city') ? old('customer_city') : (auth()->check() ? auth()->user()->city : '') }}"
                                    autocomplete="customer_city">
                                @error('customer_city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group m-0">
                                <label for="customer_zip"
                                    class="col-form-label text-md-right">{{ __('Zip') }}</label>

                                <input id="customer_zip" type="text"
                                    class="form-control @error('customer_zip') is-invalid @enderror" name="customer_zip"
                                    value="{{ old('customer_zip') ? old('customer_zip') : (auth()->check() ? auth()->user()->zip : '') }}" autocomplete="customer_zip">

                                @error('customer_zip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>

                        <div class="row justify-content-center my-3">
                            @if(auth()->guest())  
                                <p class="text-error"> <span>*</span> You must login before checkout. </p>
                            @elseif (auth()->check() && auth()->user()->email_verified_at == null)
                                <p> <span>*</span> You must verify your email before checkout. <a href="{{ route('verification.notice') }}">Resend link</a></p>
                            @endif
                            <div class="col-6">
                                <button type="submit" style="width: 100%; height: 40px;" class="btn btn-success">Checkout</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </form>


    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
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
