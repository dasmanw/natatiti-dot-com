<li class="menu-item {{ $activeClass }}">
    <a class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
        href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
        @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
        @isset($menu->icon)
            <i class="{{ $menu->icon }}"></i>
        @endisset
        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
        @isset($menu->badge)
            <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
        @endisset
    </a>

    {{-- submenu --}}
    @isset($menu->submenu)
        @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
    @endisset
</li>
