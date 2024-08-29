@php
    $currentRoute = Route::currentRouteName();

    $navRoutes = [
        'Listing' => 'product.index',
        'Add' => 'product.create',
    ];

    $icons = [
        'Listing' => 'bx bx-list-ul me-1',
        'Add' => 'bx bx-plus me-1',
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
    @if (request()->routeIs('product.edit'))
        <li class="nav-item">
            <a class="nav-link active" href="javascript:void(0)"><i class="bx bxs-user-detail me-1"></i>{{ __('Edit') }}</a>
        </li>
    @endif
</ul>
