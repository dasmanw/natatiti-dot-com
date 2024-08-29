<ul class="menu-sub">
    @if (isset($menu))
        @foreach ($menu as $submenu)
            {{-- active menu method --}}
            @php
                $activeClass = null;
                $active = 'active open';
                $currentRouteName = Route::currentRouteName();

                if (
                    $currentRouteName === $submenu->slug ||
                    (gettype($submenu->slug) === 'array' && in_array($currentRouteName, $submenu->slug))
                ) {
                    $activeClass = 'active';
                } elseif (isset($submenu->submenu)) {
                    if (gettype($submenu->slug) === 'array') {
                        foreach ($submenu->slug as $slug) {
                            if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                $activeClass = $active;
                            }
                        }
                    } else {
                        if (
                            str_contains($currentRouteName, $submenu->slug) and
                            strpos($currentRouteName, $submenu->slug) === 0
                        ) {
                            $activeClass = $active;
                        }
                    }
                }
            @endphp

            @if (isset($submenu->can))
                @canany($submenu->can)
                    @include('layouts.sections.menu.submenuItem')
                @endcanany
            @endif

            @if (isset($submenu->role))
                @role($submenu->role)
                    @include('layouts.sections.menu.submenuItem')
                @endrole
            @endif

            @if (!(isset($submenu->can) || isset($submenu->role)))
                @include('layouts.sections.menu.submenuItem')
            @endif
        @endforeach
    @endif
</ul>
