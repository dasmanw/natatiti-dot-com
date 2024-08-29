<aside class="layout-menu menu-vertical menu bg-menu-theme" id="layout-menu">

    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo justify-content-center" style="height: auto">
        <a class="app-brand-link" href="{{ url('/') }}">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/logo/logo_rectangle_transparent.png') }}"
                    alt="{{ config('app.name') }} logo" style="height: 100px">
            </span>
        </a>

        <a class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none" href="javascript:void(0);">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <ul class="menu-inner py-1">
        @foreach ($menuData[0]->menu as $menu)
            {{-- adding active and open class if child is active --}}

            {{-- menu headers --}}
            @if (isset($menu->menuHeader))
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
                </li>
            @else
                {{-- active menu method --}}
                @php
                    $activeClass = null;
                    $currentRouteName = Route::currentRouteName();

                    if (
                        $currentRouteName === $menu->slug ||
                        (gettype($menu->slug) === 'array' && in_array($currentRouteName, $menu->slug))
                    ) {
                        $activeClass = 'active open';
                    } elseif (isset($menu->submenu)) {
                        if (gettype($menu->slug) === 'array') {
                            foreach ($menu->slug as $slug) {
                                if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                    $activeClass = 'active open';
                                }
                            }
                        } else {
                            if (
                                str_contains($currentRouteName, $menu->slug) and
                                strpos($currentRouteName, $menu->slug) === 0
                            ) {
                                $activeClass = 'active open';
                            }
                        }
                    }
                @endphp

                {{-- main menu --}}
                @if (isset($menu->can))
                    @canany($menu->can)
                        @include('layouts.sections.menu.menuItem')
                    @endcanany
                @endif

                @if (isset($menu->role))
                    @role($menu->role)
                        @include('layouts.sections.menu.menuItem')
                    @endrole
                @endif

                @if (!(isset($menu->can) || isset($menu->role)))
                    @include('layouts.sections.menu.menuItem')
                @endif
            @endif
        @endforeach
    </ul>

</aside>
