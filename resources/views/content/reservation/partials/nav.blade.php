@php
    $currentRoute = Route::currentRouteName();

    $navRoutes = [
        'Listing' => 'reservation.index',
    ];

    $icons = [
        'Listing' => 'bx bx-list-ul me-1',
        'Make' => 'bx bx-plus me-1',
    ];
    if (is_salesman()) {
        $navRoutes['Make'] = 'reservation.create';
    }
@endphp

<ul class="nav nav-pills flex-column flex-md-row mb-3">
    @foreach ($navRoutes as $key => $route)
        <li class="nav-item">
            <a class="nav-link {{ $currentRoute == $route ? 'active' : '' }}"
                href="{{ $currentRoute == $route ? 'javascript:void(0)' : route($route) }}"><i
                    class="{{ $icons[$key] }}"></i>
                {{ $key }}</a>
        </li>
    @endforeach
    @if (request()->routeIs('reservation.edit'))
        <li class="nav-item">
            <a class="nav-link active" href="javascript:void(0)"><i class="bx bxs-user-detail me-1"></i>Edit</a>
        </li>
    @endif
</ul>
