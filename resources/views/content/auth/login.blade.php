@extends('layouts/blankLayout')

@section('title', 'Login')

@section('page-style')
    <!-- Page -->
    <link href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a class="app-brand-link justify-content-center flex-wrap" href="{{ url('/') }}">
                                <span class="app-brand-logo demo"><img
                                        src="{{ asset('assets/img/logo/logo_rectangle_transparent.png') }}"
                                        alt="{{ config('app.name') }} logo" style="height: 200px"></span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <form class="mb-3" id="formAuthentication" action="{{ route('auth') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" id="email" name="email" type="email"
                                    placeholder="Enter your email" autofocus required>
                                <x-invalid-input error="email" />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    <a href="{{ route('password.request') }}">
                                        <small>Forgot Password?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" id="password" name="password" type="password"
                                        aria-describedby="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        required />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                <x-invalid-input error="password" />
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" id="remember" name="remember" type="checkbox"
                                        value="true">
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
    </div>
@endsection
