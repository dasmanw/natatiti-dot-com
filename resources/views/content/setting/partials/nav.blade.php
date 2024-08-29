@php
    $currentRoute = Route::currentRouteName();

    $navRoutes = [
        'Account' => 'settings.account',
        'Password' => 'settings.password',
    ];

    $icons = [
        'Account' => 'bx bx-user me-1',
        'Password' => 'bx bx-key me-1',
    ];
@endphp

<ul class="nav nav-pills flex-column flex-md-row mb-3">
    @foreach ($navRoutes as $key => $route)
        <li class="nav-item">
            <a class="nav-link {{ $currentRoute == $route ? 'active' : '' }}"
                href="{{ $currentRoute == $route ? 'javascript:void(0)' : route($route) }}"><i
                    class="{{ $icons[$key] }}"></i>
                {{ __($key) }}</a>
        </li>
    @endforeach
</ul>
