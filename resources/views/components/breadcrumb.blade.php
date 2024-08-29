<nav aria-label="breadcrumb breadcrumb-style1">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a
                href="{{ request()->routeIs('home') ? 'javascript:void(0)' : route('home') }}">{{ __('Dashboard') }}</a>
        </li>
        {{ $slot }}
    </ol>
</nav>
