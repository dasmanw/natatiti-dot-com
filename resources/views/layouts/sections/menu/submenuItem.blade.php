<li class="menu-item {{ $activeClass }}">
    <a class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
        href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)' }}"
        @if (isset($submenu->target) and !empty($submenu->target)) target="_blank" @endif>
        @if (isset($submenu->icon))
            <i class="{{ $submenu->icon }}"></i>
        @endif
        <div>{{ isset($submenu->name) ? __($submenu->name) : '' }}</div>
        @isset($submenu->badge)
            <div class="badge bg-{{ $submenu->badge[0] }} rounded-pill ms-auto">{{ $submenu->badge[1] }}</div>
        @endisset
    </a>

    {{-- submenu --}}
    @if (isset($submenu->submenu))
        @include('layouts.sections.menu.submenu', ['menu' => $submenu->submenu])
    @endif
</li>
