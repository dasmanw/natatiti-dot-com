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
                        <form class="mb-3" id="formForgotPasswordEmail" action="{{ route('password.email') }}"
                            method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" id="email" name="email" type="email"
                                    placeholder="Enter your email" autofocus required>
                                <x-invalid-input error="email" />
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Send Email</button>
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
