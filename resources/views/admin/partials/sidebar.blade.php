<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <ul class="app-menu">
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.branches.index' ? 'active' : '' }}" href="{{ route('admin.branches.index') }}">
                <i class="app-menu__icon fa fa-briefcase"></i>
                <span class="app-menu__label">Branches</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.categories.index' ? 'active' : '' }}"
                href="{{ route('admin.categories.index') }}">
                <i class="app-menu__icon fa fa-tags"></i>
                <span class="app-menu__label">Categories</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.brands.index' ? 'active' : '' }}" href="{{ route('admin.brands.index') }}">
                <i class="app-menu__icon fa fa-briefcase"></i>
                <span class="app-menu__label">Brands</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.products.index' ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                <i class="app-menu__icon fa fa-shopping-bag"></i>
                <span class="app-menu__label">Products</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.orders.index' ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                <i class="app-menu__icon fa fa-bar-chart"></i>
                <span class="app-menu__label">Orders</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.users.index' ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="app-menu__icon fa fa-bar-chart"></i>
                <span class="app-menu__label">Users</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.roles.index' ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">
                <i class="app-menu__icon fa fa-bar-chart"></i>
                <span class="app-menu__label">Roles</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.settings' ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                <i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Settings</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.jnt.index' ? 'active' : '' }}" href="{{ route('admin.jnt.index') }}">
                <i class="app-menu__icon fa fa-bar-chart"></i>
                <span class="app-menu__label">Shipping Rate J&T</span>
            </a>
        </li>

        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.couriers.index' ? 'active' : '' }}" href="{{ route('admin.couriers.index') }}">
                <i class="app-menu__icon fa fa-bar-chart"></i>
                <span class="app-menu__label">Courier</span>
            </a>
        </li>

        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.poscode.index' ? 'active' : '' }}" href="{{ route('admin.poscode.index') }}">
                <i class="app-menu__icon fa fa-bar-chart"></i>
                <span class="app-menu__label">Poscode</span>
            </a>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Sale Expert</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li>
                <a class="app-menu__item {{ Route::currentRouteName() == 'admin.sale-expert.commissions.index' ? 'active' : '' }}" href="{{ route('admin.sale-expert.commissions.index') }}">
                    <i class="app-menu__icon fa fa-cogs"></i>
                    <span class="app-menu__label">Commissions</span>
                </a>
              </li>
              <li>
                <a class="app-menu__item {{ Route::currentRouteName() == 'admin.sale-expert.users.index' ? 'active' : '' }}" href="{{ route('admin.sale-expert.users.index') }}">
                    <i class="app-menu__icon fa fa-cogs"></i>
                    <span class="app-menu__label">Users</span>
                </a>
              </li>
            </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Personal Shopper</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li>
                <a class="app-menu__item {{ Route::currentRouteName() == 'admin.personal-shopper.commissions.index' ? 'active' : '' }}" href="{{ route('admin.personal-shopper.commissions.index') }}">
                    <i class="app-menu__icon fa fa-cogs"></i>
                    <span class="app-menu__label">Commissions</span>
                </a>
              </li>
              <li>
                <a class="app-menu__item {{ Route::currentRouteName() == 'admin.personal-shopper.users.index' ? 'active' : '' }}" href="{{ route('admin.personal-shopper.users.index') }}">
                    <i class="app-menu__icon fa fa-cogs"></i>
                    <span class="app-menu__label">Users</span>
                </a>
              </li>
            </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Agent</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li>
                <a class="app-menu__item {{ Route::currentRouteName() == 'admin.agent.commissions.index' ? 'active' : '' }}" href="{{ route('admin.agent.commissions.index') }}">
                    <i class="app-menu__icon fa fa-cogs"></i>
                    <span class="app-menu__label">Commissions</span>
                </a>
              </li>
              <li>
                <a class="app-menu__item {{ Route::currentRouteName() == 'admin.agent.users.index' ? 'active' : '' }}" href="{{ route('admin.agent.users.index') }}">
                    <i class="app-menu__icon fa fa-cogs"></i>
                    <span class="app-menu__label">Users</span>
                </a>
              </li>
            </ul>
        </li>
        {{-- <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.withdrawals.index' ? 'active' : '' }}" href="{{ route('admin.withdrawals.index') }}">
                <i class="app-menu__icon fa fa-bar-chart"></i>
                <span class="app-menu__label">Payment claim</span>
            </a>

        </li> --}}
    </ul>
</aside>
