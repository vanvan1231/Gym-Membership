@auth('backpack')
    @php
        $user = auth()->guard('backpack')->user();
        if ($user && strpos($user->capabilities, '') !== false) {
            $capabilities = explode(',', $user->capabilities);
        }
    @endphp
    @if ($crud->hasAccess('payment'))
        @if (in_array('2', $capabilities) || in_array('3', $capabilities))
            <a href="{{ url($crud->route . '/' . $entry->getKey() . '/payment') }}" class="btn btn-sm btn-link"><i
                    class="la la-dollar-sign"></i> Payment</a>
        @endif
    @endif
@endauth
