@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Edit Vendor')

@section('content')
    <x-breadcrumb>
        <li class="breadcrumb-item">{{ __('Users') }}</li>
        <li class="breadcrumb-item">{{ __('Vendor') }}</li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
    </x-breadcrumb>

    <x-page-heading>{{ __('Edit Vendor') }}</x-page-heading>

    <div class="row">
        <div class="col-md-12">
            @include('content.user.vendor.partials.nav')
            <div class="card mb-4">
                <h2 class="card-header h5">{{ __('Edit') }} {{ $vendor->name }}</h2>
                <hr class="my-0" />
                <div class="card-body">
                    <x-form action="{{ route('vendor.update', $vendor) }}" method="PUT">
                        <div class="row mb-3">
                            <x-input-responsive name="name" value="{{ $vendor->name }}" html="required maxlength=50" />
                            <div class="col-md-3 col-lg-2 d-flex align-items-end">
                                <x-button class="warning btn-pinned mb-3">{{ __('Update') }}</x-button>
                            </div>
                        </div>
                    </x-form>
                </div>
            </div>
        </div>
    </div>
@endsection
