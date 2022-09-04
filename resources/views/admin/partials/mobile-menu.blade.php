<div class="mobile-menu md:hidden">
            <div class="mobile-menu-bar">
                <a href="" class="flex mr-auto">
                    <img alt="Icewall Tailwind HTML Admin Template" class="w-6" src="{{ asset('dist/images/logo.svg') }}">
                </a>
                <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
            </div>
            <ul class="border-t border-theme-2 py-5 hidden">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="menu {{ \Route::is('admin.dashboard') ? 'side-menu--active' : ''  }}">
                        <div class="menu__icon"> <i data-feather="home"></i> </div>
                        <div class="menu__title"> Dashboard </div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.visitors.index') }}" class="side-menu {{ request()->is('dashboard/visitors*') ? 'side-menu--active' : ''  }}">
                        <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                        <div class="side-menu__title"> Visitors </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.activities.index') }}" class="side-menu {{ request()->is('dashboard/activities*') ? 'side-menu--active' : ''  }}">
                        <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="side-menu__title"> Add ons </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.days.index') }}" class="side-menu {{ request()->is('dashboard/days*') ? 'side-menu--active' : ''  }}">
                        <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="side-menu__title"> Days</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.packages.index') }}" class="side-menu {{ request()->is('dashboard/packages*') ? 'side-menu--active' : ''  }}">
                        <div class="side-menu__icon"> <i data-feather="package"></i> </div>
                        <div class="side-menu__title"> Packages </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.roles.index') }}" class="side-menu {{ request()->is('dashboard/roles*') ? 'side-menu--active' : ''  }}">
                        <div class="side-menu__icon"> <i data-feather="message-square"></i> </div>
                        <div class="side-menu__title"> Roles </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.specials.index') }}" class="side-menu {{ request()->is('dashboard/specials*') ? 'side-menu--active' : ''  }}">
                        <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                        <div class="side-menu__title"> Special Users </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.internals.index') }}" class="side-menu {{ request()->is('dashboard/internals*') ? 'side-menu--active' : ''  }}">
                        <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                        <div class="side-menu__title"> Internal Users </div>
                    </a>
                </li>
            </ul>
        </div>