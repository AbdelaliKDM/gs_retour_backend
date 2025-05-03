@php
    $pending_payments = \App\Models\Payment::where('status', 'pending')->count();
    $inactive_users = \App\Models\User::whereHas('statuses', function($query){
        $query->where('name', 'inactive')
        ->whereIn('type', ['profile', 'truck']);
    })->count();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo">
        <a href="{{ route('dashboard-analytics') }}" class="app-brand-link"></a>

        <img src="{{ asset((session('theme') ?? 'light') . '.png') }}" class="w-auto h-px-40">

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-autod-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
            <a href="/" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>{{ __('app.dashboard') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('user/*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                @if ($inactive_users)
                    <i class="menu-icon tf-icons bx bx-user bx-tada bx-rotate-180" style="color:#ff8001"></i>
                @else
                    <i class="menu-icon tf-icons bx bx-user"></i>
                @endif
                <div>{{ __('app.users') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('user/index') && request('role') == 'renter' ? 'active' : '' }}">
                    <a href="/user/index?role=renter" class="menu-link">
                        <div>{{ __('app.renters') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('user/index') && request('role') == 'driver' ? 'active' : '' }}">
                    <a href="/user/index?role=driver" class="menu-link">
                        <div>{{ __('app.drivers') }}</div>
                    </a>
                </li>
                <li
                    class="menu-item {{ request()->is('user/index') && request('status') == 'inactive' ? 'active' : '' }}">
                    <a href="/user/index?status=inactive" class="menu-link">
                        <div>{{ __('app.inactive_users') }}</div>
                    </a>
                </li>
                <li
                    class="menu-item {{ request()->is('user/index') && request('status') == 'suspended' ? 'active' : '' }}">
                    <a href="/user/index?status=suspended" class="menu-link">
                        <div>{{ __('app.suspended_users') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ request()->is('category/*') ? 'active' : '' }}">
            <a href="/category/index" class="menu-link">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div>{{ __('app.categories') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('subcategory/*') ? 'active' : '' }}">
            <a href="/subcategory/index" class="menu-link">
                <i class="menu-icon tf-icons bx bx-category-alt"></i>
                <div>{{ __('app.subcategories') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('truckType/*') ? 'active' : '' }}">
            <a href="/truckType/index" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bus"></i>
                <div>{{ __('app.truckTypes') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('shipmentType/*') ? 'active' : '' }}">
            <a href="/shipmentType/index" class="menu-link">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div>{{ __('app.shipmentTypes') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('trip/*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-trip"></i>
                <div>{{ __('app.trips') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('trip/pending') ? 'active' : '' }}">
                    <a href="/trip/pending" class="menu-link">
                        <div>{{ __('app.pending_trips') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('trip/ongoing') ? 'active' : '' }}">
                    <a href="/trip/ongoing" class="menu-link">
                        <div>{{ __('app.ongoing_trips') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('trip/paused') ? 'active' : '' }}">
                    <a href="/trip/paused" class="menu-link">
                        <div>{{ __('app.paused_trips') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('trip/canceled') ? 'active' : '' }}">
                    <a href="/trip/canceled" class="menu-link">
                        <div>{{ __('app.canceled_trips') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('trip/completed') ? 'active' : '' }}">
                    <a href="/trip/completed" class="menu-link">
                        <div>{{ __('app.completed_trips') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ request()->is('payment/*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              @if ($pending_payments)
              <i class="menu-icon tf-icons bx bx-credit-card bx-tada bx-rotate-180" style="color:#ff8001"></i>
              @else
              <i class="menu-icon tf-icons bx bx-credit-card"></i>
              @endif

                <div>{{ __('app.payments') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('payment/wallet') ? 'active' : '' }}">
                    <a href="/payment/wallet" class="menu-link">
                        <div>{{ __('app.wallet_payments') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('payment/invoice') ? 'active' : '' }}">
                    <a href="/payment/invoice" class="menu-link">
                        <div>{{ __('app.invoice_payments') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ request()->is('notice/*') ? 'active' : '' }}">
            <a href="/notice/index" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bell"></i>
                <div>{{ __('app.notices') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('documentation/*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-info-square"></i>
                <div>{{ __('app.documentation') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('documentation/privacy_policy') ? 'active' : '' }}">
                    <a href="/documentation/privacy_policy" class="menu-link">
                        <div>{{ __('app.privacy_policy') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('documentation/about_app') ? 'active' : '' }}">
                    <a href="/documentation/about_app" class="menu-link">
                        <div>{{ __('app.about_app') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('documentation/terms_of_use') ? 'active' : '' }}">
                    <a href="/documentation/terms_of_use" class="menu-link">
                        <div>{{ __('app.terms_of_use') }}</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
