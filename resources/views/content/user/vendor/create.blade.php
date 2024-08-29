@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Vendor Registeration')

@section('content')
    <x-breadcrumb>
        <li class="breadcrumb-item">{{ __('Users') }}</li>
        <li class="breadcrumb-item">{{ __('Vendor') }}</li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Registeration') }}</li>
    </x-breadcrumb>

    <x-page-heading>{{ __('Vendor Registeration') }}</x-page-heading>

    <div class="row">
        <div class="col-md-12">
            @include('content.user.vendor.partials.nav')
            <div class="card mb-4">
                <h5 class="card-header">{{ __('Registeration') }}</h5>
                <hr class="my-0" />
                <div class="card-body">
                    <x-form action="{{ route('vendor.store') }}">
                        <div class="row mb-3">
                            <x-input-responsive name="name" html="required maxlength=50" />
                            <x-input-responsive name="email" type="email" html="required maxlength=255" />
                            <x-input-responsive name="password" type="password" html="required" />
                            <div class="col-md-3 col-lg-2 d-flex align-items-end">
                                <x-button class="primary btn-pinned mb-3">Save</x-button>
                            </div>
                        </div>
                    </x-form>
                </div>
            </div>
        </div>
    </div>
@endsection
