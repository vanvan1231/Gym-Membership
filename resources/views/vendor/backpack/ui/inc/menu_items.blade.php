@auth('backpack')
    @php
        $user = auth()->guard('backpack')->user();
        if ($user && strpos($user->capabilities, '') !== false) {
            $capabilities = explode(',', $user->capabilities);
        }
    @endphp
    @isset($capabilities)
        {{-- This file is used for menu items by any Backpack v6 theme --}}
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>
                {{ trans('backpack::base.dashboard') }}</a></li>
        @if (in_array('1', $capabilities))
            <x-backpack::menu-item title="Users" icon="la la-user-secret" :link="backpack_url('user')" />
        @endif
        @if (in_array('5', $capabilities))
            <x-backpack::menu-item title="Members" icon="la la-users" :link="backpack_url('member')" />
        @endif
        @if (count(array_intersect(['4', '5', '6', '7'], $capabilities)) > 0)
            <x-backpack::menu-dropdown title="Reports" icon="la la-flag">
                @if (in_array('4', $capabilities))
                    <x-backpack::menu-dropdown-item title="Daily Checkin" icon="la la-user" :link="backpack_url('show-checkins')" />
                @endif
                @if (in_array('5', $capabilities))
                    <x-backpack::menu-dropdown-item title="Members" icon="la la-group" :link="backpack_url('show-member')" />
                @endif
                @if (in_array('6', $capabilities))
                    <x-backpack::menu-dropdown-item title="Payments " icon="la la-key" :link="backpack_url('show-payments')" />
                @endif
                @if (in_array('7', $capabilities))
                    <x-backpack::menu-dropdown-item title="Cashflow " icon="la la-wallet" :link="backpack_url('cashflow')" />
                @endif
            </x-backpack::menu-dropdown>
        @endif


        {{-- <x-backpack::menu-item title="Payments" icon="la la-money-bill-wave" :link="backpack_url('payment')" /> --}}
        {{-- <x-backpack::menu-item title="Memberships" icon="la la-question" :link="backpack_url('membership')" /> --}}


        {{-- <x-backpack::menu-item title="Reports" icon="la la-flag" :link="backpack_url('checkin')" /> --}}
    @endisset
@endauth
