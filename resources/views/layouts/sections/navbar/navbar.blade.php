@php
    $containerNav = $containerNav ?? 'container-fluid';
    $navbarDetached = $navbarDetached ?? '';

@endphp

<!-- Navbar -->
@if (isset($navbarDetached) && $navbarDetached == 'navbar-detached')
    <nav class="layout-navbar {{ $containerNav }} navbar navbar-expand-xl {{ $navbarDetached }} align-items-center bg-navbar-theme"
        id="layout-navbar">
@endif
@if (isset($navbarDetached) && $navbarDetached == '')
    <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="{{ $containerNav }}">
@endif

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
@if (isset($navbarFull))
    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
        <a class="app-brand-link gap-2" href="{{ url('/') }}">
            <span class="app-brand-logo demo">@include('_partials.macros', ['width' => 25, 'withbg' => 'var(--bs-primary)'])</span>
            <span class="app-brand-text demo menu-text fw-bold">{{ config('variables.templateName') }}</span>
        </a>
    </div>
@endif

<!-- ! Not required for layout-without-menu -->
@if (!isset($navbarHideToggle))
    <div
        class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ? ' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>
@endif

<div class="navbar-nav-right d-flex align-items-center {{ app()->getLocale() == 'ar' ? 'justify-content-end' : '' }}"
    id="navbar-collapse">
    {{-- <!-- Search -->
        <div class="navbar-nav align-items-center">
          <div class="nav-item d-flex align-items-center">
            <i class="bx bx-search fs-4 lh-0"></i>
            <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2" placeholder="Search..." aria-label="Search...">
          </div>
        </div>
        <!-- /Search --> --}}
    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <i class="bx bx-globe bx-sm"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item {{ app()->getLocale() == "en" ? 'active' : '' }}"
                        href="{{ route('language.change',['lang' => "en"]) }}">
                        <span class="align-middle">English</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item {{ app()->getLocale() == "ar" ? 'active' : '' }}"
                        href="{{ route('language.change',['lang' => "ar"]) }}">
                        <span class="align-middle">Arabic</span>
                    </a>
                </li>
            </ul>
        </li>
        @if (is_salesman())
            @php
                $carts = isset($carts) ? $carts : auth()->user()->carts()->with('product')->get();
                $cartCount = $carts->count();
            @endphp
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" data-bs-toggle="dropdown" href="javascript:void(0);">
                    <span class="flex-grow-1 align-middle"><i class="bx bx-cart"></i></span>
                    <span
                        class="flex-shrink-0 badge badge-center rounded-pill bg-info w-px-20 h-px-20">{{ $cartCount }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" style="min-width: 210px;">
                    @forelse ($carts as $cart)
                        <li>
                            <div class="dropdown-item">
                                <div class="d-flex justify-content-between">
                                    <span>{{ $cart->product?->name }}</span>
                                    <form action="{{ route('cart.destroy', $cart) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger rounded-pill" type="submit"><i
                                                class="bx bx-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li>
                            <div class="dropdown-item">
                                No Products Added
                            </div>
                        </li>
                    @endforelse
                    @if ($cartCount > 0)
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <div class="dropdown-item text-center">
                                <a class="btn btn-sm btn-primary" href="{{ route('cart.index') }}">Check Out</a>
                            </div>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" data-bs-toggle="dropdown" href="javascript:void(0);">
                <div class="avatar avatar-online">
                    <style>
                        .nav-pic svg {
                            width: 40px;
                            height: 40px;
                        }
                    </style>
                    <div class="nav-pic">{!! Avatar::create(auth()->user()->name)->toSvg() !!}</div>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="javascript:void(0);">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    <div class="nav-pic">{!! Avatar::create(auth()->user()->name)->toSvg() !!}</div>
                                </div>
                            </div>
                            @php
                                $user = auth()->user();
                            @endphp
                            <div class="flex-grow-1">
                                <span class="fw-medium d-block">{{ $user->name }}</span>
                                <small class="text-muted">{{ $user?->roles[0]?->name }}</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('settings.account') }}">
                        <i class='bx bx-cog me-2'></i>
                        <span class="align-middle">Settings</span>
                    </a>
                </li>
                {{-- <li>
                <a class="dropdown-item" href="javascript:void(0);">
                  <span class="d-flex align-items-center align-middle">
                    <i class="flex-shrink-0 bx bx-credit-card me-2 pe-1"></i>
                    <span class="flex-grow-1 align-middle">Billing</span>
                    <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                  </span>
                </a>
              </li> --}}
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal"
                        href="javascript:void(0);">
                        <i class='bx bx-power-off me-2'></i>
                        <span class="align-middle">Log Out</span>
                    </a>
                </li>
            </ul>
        </li>
        <!--/ User -->
    </ul>
</div>

@if (!isset($navbarDetached))
    </div>
@endif
</nav>
<!-- / Navbar -->
{{-- Logout Modal --}}
<div class="modal modal-sm fade" id="logoutModal" aria-labelledby="logoutLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="logoutLabel">Logout Confirmation</h1>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to log out?</p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                    <button class="btn btn-danger" id="logoutBtn" type="submit">Logout</button>
                </div>
            </form>
        </div>
    </div>
</div>
