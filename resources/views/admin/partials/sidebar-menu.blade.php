<nav class="side-nav">
    <ul>
        <li>
            <a href="{{ route('admin.dashboard') }}" class="side-menu {{ \Route::is('admin.dashboard') ? 'side-menu--active' : ''  }}">
                <div class="menu__icon"> <i data-feather="home"></i> </div>
                <div class="side-menu__title">Dashboard </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.activities.index') }}" class="side-menu {{ request()->is('dashboard/activities*') ? 'side-menu--active' : ''  }}">
                <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                <div class="side-menu__title"> Add ons </div>
            </a>
        </li>
        <li>
            <a 
                href="{{ route('admin.days.index') }}" 
                class="side-menu {{ request()->is('dashboard/days*') ? 'side-menu--active' : ''  }}">
                <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                <div class="side-menu__title"> Days </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.packages.index') }}" class="side-menu {{ request()->is('dashboard/packages*') ? 'side-menu--active' : ''  }}">
                <div class="side-menu__icon"> <i data-feather="package"></i> </div>
                <div class="side-menu__title"> Packages </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.orders.index') }}" class="side-menu {{ request()->is('dashboard/orders*') ? 'side-menu--active' : ''  }}">
                <div class="side-menu__icon"> <i data-feather="package"></i> </div>
                <div class="side-menu__title"> Orders </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.bulk.file.upload') }}" class="side-menu {{ request()->is('dashboard/bulk-import*') ? 'side-menu--active' : ''  }}">
                <div class="side-menu__icon"> <i data-feather="package"></i> </div>
                <div class="side-menu__title"> Bulk import </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.roles.index') }}" class="side-menu {{ request()->is('dashboard/roles*') ? 'side-menu--active' : ''  }}">
                <div class="side-menu__icon"> <i data-feather="message-square"></i> </div>
                <div class="side-menu__title"> Roles </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.visitors.index') }}" class="side-menu {{ request()->is('dashboard/visitors*') ? 'side-menu--active' : ''  }}">
                <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                <div class="side-menu__title"> Visitors </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.specials.index') }}" class="side-menu {{ request()->is('dashboard/specials*') ? 'side-menu--active' : ''  }}">
                <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                <div class="side-menu__title"> Special Users </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.internals.index') }}" class="side-menu {{ request()->is('dashboard/internal-users*') ? 'side-menu--active' : ''  }}">
                <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                <div class="side-menu__title"> Internal Users </div>
            </a>
        </li>
        <li>
            <a href="javascript:" class="side-menu side-menu--active' : ''  }}">
                <div class="side-menu__icon"> <i data-feather="message-square"></i> </div>
                <div class="side-menu__title">
                    Activity Logs
                    <div class="side-menu__sub-icon ">
                        <i data-feather="chevron-down"></i>
                    </div>
                </div>
            </a>
            <ul class="{{ request()->is('dashboard/activity-log*') ? 'side-menu__sub-open' : ''  }}">
                <li>
                    <a href="{{ route('admin.log.add-on.index') }}" class="side-menu {{ request()->is('dashboard/activity-log/add-on/*') ? 'side-menu--active' : ''  }}">
                        <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="side-menu__title"> Add on </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.log.package.index') }}" class="side-menu {{ request()->is('dashboard/activity-log/package/*') ? 'side-menu--active' : ''  }}">
                        <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="side-menu__title"> Package </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.log.visitor.index') }}" class="side-menu {{ request()->is('dashboard/activity-log/package/*') ? 'side-menu--active' : ''  }}">
                        <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="side-menu__title"> Visitor </div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
