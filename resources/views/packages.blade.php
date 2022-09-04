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
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Special users
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                         @if(Auth::guard('specialUser')->check())
                            <a href="{{ route('special-user.home') }}" class="dropdown-item"> Profile </a>

                            <div class="" aria-labelledby="">

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>

                        @else
                            <a href="{{ route('special-user.user.create') }}" class="dropdown-item">Register</a>
                            <a href="{{ route('special-user.login.form') }}" class="dropdown-item"> Login </a>

                        @endif
                    </div>
                </li>
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
                <!-- <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="/cart">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                        <span class="ml-1">{{ session()->has('cart_items') ? session()->get('cart_items') : 0 }}</span>
                    </a>
                </li> -->
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5" id="package-container">

    @if(Session::has('cart_errors') && sizeof(Session::get('cart_errors')) > 0)
        @foreach(Session::get('cart_errors') as $cart_error)
        <div class="alert alert-danger mt-4 container" role="alert">
            {{ $cart_error }}
        </div>
        @endforeach
    @endif

    @if(Session::has('special-user-create'))
        <div class="alert alert-success mt-4 container" role="alert">
            {{ Session::get('special-user-create') }}
        </div>
    @endif

    @php $cart = session()->has('cart') ? session()->get('cart') : []; @endphp
    @php $ses_package = $ses_package ?? null; @endphp
    <!-- Types -->
    @if(count($types) > 0)
    <div class="package-types">
        <nav>
            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                @foreach($types as $type)
                <a 
                    class="nav-item nav-link {{ isset($ses_package['package_type_id']) ? ($ses_package['package_type_id'] == $type->id ? 'active' : '') : ($loop->iteration == 1 ? 'active' : '') }}" 
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
            <div class="tab-pane fade show {{  isset($ses_package['package_type_id']) ? ($ses_package['package_type_id'] == $type->id ? 'active' : '') : ($loop->iteration == 1 ? 'active' : '') }}" id="nav-type-{{ $loop->iteration }}" role="tabpanel" aria-labelledby="nav-type-{{$loop->iteration}}-tab">
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

                            <div id="day-{{ $loop->iteration }}" class="collapse {{ isset($ses_package['day']) ? ($ses_package['day'] == $day ? 'show' : '' ) : ($loop->iteration == 1 ? 'show' : '') }}" aria-labelledby="day-heading-{{ $loop->iteration }}" data-parent="#accordion">
                                <div class="card-body">
                                    @if(count($packages) > 0)
                                    <div id="{{ Str::slug(Str::lower($day)) }}">
                                        
                                        @foreach($packages as $package)
                                            @php 
                                                $cart_package_type = $cart[$type->id] ?? null;
                                                
                                                $cart_day = $cart_package_type ? $cart_package_type[$day] ?? null : null; 
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
                                                            data-day="{{ $day }}"
                                                            data-package-id="{{ $package->id }}"
                                                        >
                                                            <input type="hidden" name="price" class="price" value="{{ $package->price }}" />
                                                            <input type="hidden" name="subtotal" class="subtotal" value="{{ $cart_package ? $cart_package['qty'] * $package->price : $package->price }}" />
                                                            <span>Price: {{ $package->price }}</span>
                                                            @php $cart_addons_price = 0; @endphp
                                                            @if(isset($cart_package['activities']))
                                                                @php 
                                                                    $cart_addons_price = 0;
                                                                    foreach ($cart_package['activities'] as $activity) {
                                                                        if (isset($activity['price'], $activity['qty'])) {
                                                                            $cart_addons_price += $activity['price'] * $activity['qty'];
                                                                        }
                                                                        
                                                                    }
                                                                @endphp
                                                            @endif
                                                            <span class="subtotal-preview">Sub Total: {{  $cart_package ? $cart_addons_price + ($cart_package['qty'] * $package->price) : $package->price  }}</span>
                                                            <input type="number" name="qty" class="qty" min="1" max="{{  $package->quantity }}" value="{{ $cart_package ? $cart_package['qty'] : 1 }}" />
                                                            <button class="btn btn-success btn-lg add-to-cart">{{ $cart_package ? 'Update Cart' : 'Add to cart' }}</button>
                                                            @if($cart_package)
                                                                <button class="btn btn-danger btn-lg remove-cart">Remove</button>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>

                                                <div id="package-{{ $package->id }}" class="collapse {{ isset($ses_package['package_id']) ? ($ses_package['package_id'] == $package->id ? 'show' : '' ) : ($loop->iteration == 1 ? 'show' : '') }}" aria-labelledby="package-heading-{{ $loop->iteration }}" data-parent="#{{ Str::slug(Str::lower($day)) }}">
                                                    <div class="card-body">
                                                        @if(count($package->concert_activities()) > 0)
                                                        <a 
                                                            class="btn btn-lg concert-toggle {{ isset($cart_package['join_concert']) && $cart_package['join_concert'] == 'true' ? 'active btn-success' : 'btn-primary' }}" 
                                                            id="nav-join-concert-tab"
                                                            data-concerts="{{ isset($cart_package['concerts']) ? json_encode($cart_package['concerts']) : json_encode([]) }}" 
                                                            data-type="join_concert"
                                                            data-toggle="tab" 
                                                            href="#nav-type-join-concert" 
                                                            role="tab" 
                                                            aria-controls="nav-type-join-concert" 
                                                            aria-selected="{{ isset($cart_package['join_concert']) && $cart_package['join_concert'] == 'true' ? true : false }}">I want to join concert</a>
                                                        <a 
                                                            class="btn btn-lg concert-toggle {{ !isset($cart_package['join_concert']) || ( isset($cart_package['join_concert']) && $cart_package['join_concert'] == 'false') ? 'active btn-success' : 'btn-primary' }}" 
                                                            id="nav-not-join-concert-tab"
                                                            data-concerts="{{ isset($cart_package['concerts']) ? json_encode($cart_package['concerts']) : json_encode([]) }}"  
                                                            data-type="not_join_concert"
                                                            data-toggle="tab" 
                                                            href="#nav-type-not-join-concert" 
                                                            role="tab" 
                                                            aria-controls="nav-type-not-join-concert" 
                                                            aria-selected="{{ !isset($cart_package['join_concert']) || $cart_package['join_concert'] == 'false' ? true : false }}">I don't want to join concert</a>
                                                        
                                                        <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                                            <div class="tab-pane fade show {{  isset($cart_package['join_concert']) && $cart_package['join_concert'] == 'true' ? 'active' : '' }}" id="nav-type-join-concert" role="tabpanel" aria-labelledby="nav-type-join-concert-tab">

                                                                <h3 class="mt-3">Concert</h3>

                                                                <div class="row">
                                                                    @foreach($package->concert_activities() as $activity)
                                                                        <div class="col-md-3">
                                                                            @if(is_array($activity->images) && sizeof($activity->images) > 0)
                                                                                <img src="{{ asset('uploads/activity/' . $activity->images[0]) }}" class="activity-image" alt="Activity image" />
                                                                            @endif
                                                                            <h3 class="activity-title">{{ $activity->name }}</h3>
                                                                            @if($activity->price > 0)
                                                                                <p>Price: {{ $activity->price }}</p>
                                                                                @if(isset($cart_package['concerts']) && isset($cart_package['concerts'][$activity->id]))
                                                                                    <div class="row">
                                                                                        <input 
                                                                                            type="number" 
                                                                                            id="package_{{$package->id}}_activity_{{$activity->id}}" 
                                                                                            value="{{ $cart_package['concerts'][$activity->id]['qty'] }}" 
                                                                                            class="concert-activity-qty form-control col-4" 
                                                                                            data-package-type-id="{{ $type->id }}"
                                                                                            data-package-id="{{ $package->id }}"
                                                                                            data-day="{{ $day }}"
                                                                                            data-package-price="0"
                                                                                            data-qty="{{ $cart_package['qty'] }}"
                                                                                            data-concert-id="{{ $activity->id }}"
                                                                                            data-concert-price="{{ $activity->price }}"
                                                                                            min = "0"
                                                                                            data-concert="true"
                                                                                        />
                                                                                        <button 
                                                                                            class="btn btn-danger btn-sm remove-concert ml-2" 
                                                                                            data-package-type-id="{{ $type->id }}"
                                                                                            data-package-id="{{ $package->id }}"
                                                                                            data-day="{{ $day }}"
                                                                                            data-package-price="0"
                                                                                            data-qty="{{ $cart_package['qty'] }}"
                                                                                            data-concert-id="{{ $activity->id }}"
                                                                                            data-concert-price="{{ $activity->price }}"
                                                                                            data-concert="true">Remove</button>
                                                                                    </div>
                                                                                @else
                                                                                    <button 
                                                                                        class="btn btn-success btn-sm add-concert" 
                                                                                        data-package-type-id="{{ $type->id }}"
                                                                                        data-package-id="{{ $package->id }}"
                                                                                        data-day="{{ $day }}"
                                                                                        data-package-price="0"
                                                                                        data-qty="{{ $cart_package['qty'] ?? 1 }}"
                                                                                        data-concert-id="{{ $activity->id }}"
                                                                                        data-concert-price="{{ $activity->price }}"
                                                                                        data-concert="true">Add</button>
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
                                                                </div>

                                                                @if(count($package->paid_activities()) > 0)
                                                                    <h3 class="mt-3">Recommend Activities</h3>

                                                                    <div class="row">
                                                                        @foreach($package->paid_activities() as $activity)
                                                                            <div class="col-md-3">
                                                                                @if(is_array($activity->images) && sizeof($activity->images) > 0)
                                                                                    <img src="{{ asset('uploads/activity/' . $activity->images[0]) }}" class="activity-image" alt="Activity image" />
                                                                                @endif
                                                                                <h3 class="activity-title">{{ $activity->name }}</h3>
                                                                                @if($activity->price > 0)
                                                                                    <p>Price: {{ $activity->price }}</p>
                                                                                    @if(isset($cart_package['activities']) && isset($cart_package['activities'][$activity->id]))

                                                                                        <div class="row">
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="package_{{$package->id}}_activity_{{$activity->id}}" 
                                                                                                value="{{ $cart_package['activities'][$activity->id]['qty'] }}" 
                                                                                                class="update-activity-qty form-control col-4" 
                                                                                                data-package-type-id="{{ $type->id }}"
                                                                                                data-package-id="{{ $package->id }}"
                                                                                                data-day="{{ $day }}"
                                                                                                data-price="{{ $package->price }}"
                                                                                                data-qty="{{ $cart_package['qty'] }}"
                                                                                                data-addon-id="{{ $activity->id }}"
                                                                                                data-addon-price="{{ $activity->price }}"
                                                                                                min = "0"
                                                                                                data-concert="true"
                                                                                            />
                                                                                            <button 
                                                                                                class="btn btn-danger btn-sm remove-addon ml-2" 
                                                                                                data-id="{{ $activity->id }}" 
                                                                                                data-price="{{ $activity->price }}"
                                                                                                data-concert="true">Remove</button>
                                                                                        </div>
                                                                                    @else
                                                                                        <button 
                                                                                            class="btn btn-success btn-sm add-on" 
                                                                                            data-id="{{ $activity->id }}" 
                                                                                            data-price="{{ $activity->price }}"
                                                                                            data-concert="true"
                                                                                            {{ (isset($cart_package['join_concert']) && $cart_package['join_concert'] == 'true' && isset($cart_package['concerts']) && count($cart_package['concerts']) < 1) ?  'disabled' : '' }}>Add</button>
                                                                                    @endif
                                                                                @endif
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                                @if(count($package->paid_activities()) > 0)

                                                                    <h3 class="mt-3">Included Activities</h3>

                                                                    <div class="row">

                                                                        @foreach($package->free_activities() as $activity)
                                                                            <div class="col-md-3">
                                                                                @if(is_array($activity->images) && sizeof($activity->images) > 0)
                                                                                    <img src="{{ asset('uploads/activity/' . $activity->images[0]) }}" class="activity-image" alt="Activity image" />
                                                                                @endif
                                                                                <h3 class="activity-title">{{ $activity->name }}</h3>
                                                                            </div>
                                                                        @endforeach
                                                                            
                                                                    </div>
                                                                @endif

                                                            </div>

                                                            <div class="tab-pane fade show {{  !isset($cart_package['join_concert']) || $cart_package['join_concert'] == 'false' ? 'active' : '' }}" id="nav-type-not-join-concert" role="tabpanel" aria-labelledby="nav-type-not-join-concert-tab">
                                                                @if(count($package->paid_activities()) > 0)
                                                                    <h3 class="mt-3">Recommend Activities</h3>

                                                                    <div class="row">
                                                                        @foreach($package->paid_activities() as $activity)
                                                                            <div class="col-md-3">
                                                                                @if(is_array($activity->images) && sizeof($activity->images) > 0)
                                                                                    <img src="{{ asset('uploads/activity/' . $activity->images[0]) }}" class="activity-image" alt="Activity image" />
                                                                                @endif
                                                                                <h3 class="activity-title">{{ $activity->name }}</h3>
                                                                                @if($activity->price > 0)
                                                                                    <p>Price: {{ $activity->price }}</p>
                                                                                    @if(isset($cart_package['activities']) && isset($cart_package['activities'][$activity->id]))

                                                                                        <div class="row">
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="package_{{$package->id}}_activity_{{$activity->id}}" 
                                                                                                value="{{ $cart_package['activities'][$activity->id]['qty'] }}" 
                                                                                                class="update-activity-qty form-control col-4" 
                                                                                                data-package-type-id="{{ $type->id }}"
                                                                                                data-package-id="{{ $package->id }}"
                                                                                                data-day="{{ $day }}"
                                                                                                data-price="{{ $package->price }}"
                                                                                                data-qty="{{ $cart_package['qty'] }}"
                                                                                                data-addon-id="{{ $activity->id }}"
                                                                                                data-addon-price="{{ $activity->price }}"
                                                                                                min = "0"
                                                                                                data-concert="false"
                                                                                            />
                                                                                            <button 
                                                                                                class="btn btn-danger btn-sm remove-addon ml-2" 
                                                                                                data-id="{{ $activity->id }}" 
                                                                                                data-price="{{ $activity->price }}"
                                                                                                data-concert="false">Remove</button>
                                                                                        </div>
                                                                                    @else
                                                                                        <button 
                                                                                            class="btn btn-success btn-sm add-on" 
                                                                                            data-id="{{ $activity->id }}" 
                                                                                            data-price="{{ $activity->price }}"
                                                                                            data-concert="false">Add</button>
                                                                                    @endif
                                                                                @endif
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                                @if(count($package->paid_activities()) > 0)

                                                                    <h3 class="mt-3">Included Activities</h3>

                                                                    <div class="row">

                                                                        @foreach($package->free_activities() as $activity)
                                                                            <div class="col-md-3">
                                                                                @if(is_array($activity->images) && sizeof($activity->images) > 0)
                                                                                    <img src="{{ asset('uploads/activity/' . $activity->images[0]) }}" class="activity-image" alt="Activity image" />
                                                                                @endif
                                                                                <h3 class="activity-title">{{ $activity->name }}</h3>
                                                                            </div>
                                                                        @endforeach
                                                                            
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @else

                                                            @if(count($package->paid_activities()) > 0)
                                                                <h3 class="mt-3">Recommend Activities</h3>

                                                                <div class="row">
                                                                    @foreach($package->paid_activities() as $activity)
                                                                        <div class="col-md-3">
                                                                            @if(is_array($activity->images) && sizeof($activity->images) > 0)
                                                                                <img src="{{ asset('uploads/activity/' . $activity->images[0]) }}" class="activity-image" alt="Activity image" />
                                                                            @endif
                                                                            <h3 class="activity-title">{{ $activity->name }}</h3>
                                                                            @if($activity->price > 0)
                                                                                <p>Price: {{ $activity->price }}</p>
                                                                                @if(isset($cart_package['activities']) && isset($cart_package['activities'][$activity->id]))

                                                                                    <div class="row">
                                                                                        <input 
                                                                                            type="number" 
                                                                                            id="package_{{$package->id}}_activity_{{$activity->id}}" 
                                                                                            value="{{ $cart_package['activities'][$activity->id]['qty'] }}" 
                                                                                            class="update-activity-qty form-control col-4" 
                                                                                            data-package-type-id="{{ $type->id }}"
                                                                                            data-package-id="{{ $package->id }}"
                                                                                            data-day="{{ $day }}"
                                                                                            data-price="{{ $package->price }}"
                                                                                            data-qty="{{ $cart_package['qty'] }}"
                                                                                            data-addon-id="{{ $activity->id }}"
                                                                                            data-addon-price="{{ $activity->price }}"
                                                                                            min = "0"
                                                                                            data-concert="{{ isset($cart_package['join_concert']) && $cart_package['join_concert'] == 'true' }}"
                                                                                        />
                                                                                        <button 
                                                                                            class="btn btn-danger btn-sm remove-addon ml-2" 
                                                                                            data-id="{{ $activity->id }}" 
                                                                                            data-price="{{ $activity->price }}"
                                                                                            data-concert="{{ isset($cart_package['join_concert']) && $cart_package['join_concert'] == 'true' }}">Remove</button>
                                                                                    </div>
                                                                                @else
                                                                                    <button 
                                                                                        class="btn btn-success btn-sm add-on" 
                                                                                        data-id="{{ $activity->id }}" 
                                                                                        data-price="{{ $activity->price }}"
                                                                                        data-concert="{{ (bool) isset($cart_package['join_concert']) && $cart_package['join_concert'] == 'true' }}"
                                                                                        {{ (isset($cart_package['join_concert']) && $cart_package['join_concert'] == 'true' && isset($cart_package['concerts']) && count($cart_package['concerts']) < 1) ?  'disabled' : '' }}>Add</button>
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                            @if(count($package->paid_activities()) > 0)

                                                                <h3 class="mt-3">Included Activities</h3>

                                                                <div class="row">

                                                                    @foreach($package->free_activities() as $activity)
                                                                        <div class="col-md-3">
                                                                            @if(is_array($activity->images) && sizeof($activity->images) > 0)
                                                                                <img src="{{ asset('uploads/activity/' . $activity->images[0]) }}" class="activity-image" alt="Activity image" />
                                                                            @endif
                                                                            <h3 class="activity-title">{{ $activity->name }}</h3>
                                                                        </div>
                                                                    @endforeach
                                                                        
                                                                </div>
                                                            @endif

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

@if(session()->has('cart_items') &&  session()->get('cart_items') > 0)
<div class="cart-content">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <span class="ml-1">Package: {{ session()->has('cart_items') ? session()->get('cart_items') : 0 }}</span>
                <a href="/clear/cart" class="clear">clear</a>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <span class="total_price">{{ number_format($total, 2) }} SAR</span>
                <a href="/checkout" class="btn btn-success btn-next">Next</a>
            </div>
        </div>
    </div>
</div>
@endif
