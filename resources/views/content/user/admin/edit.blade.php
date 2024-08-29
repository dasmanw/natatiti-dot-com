@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Edit Admin')

@section('content')
    <x-breadcrumb>
        <li class="breadcrumb-item">{{ __('Users') }}</li>
        <li class="breadcrumb-item">{{ __('Admin') }}</li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
    </x-breadcrumb>

    <x-page-heading>{{ __('Edit Admin') }}</x-page-heading>

    <div class="row">
        <div class="col-md-12">
            @include('content.user.admin.partials.nav')
            <div class="card mb-4">
                <h2 class="card-header h5">{{ __('Edit') }} {{ $admin->name }}</h2>
                <hr class="my-0" />
                <div class="card-body">
                    <x-form action="{{ route('admin.update', $admin) }}" method="PUT">
                        <div class="row mb-3">
                            <x-input-responsive name="name" value="{{ $admin->name }}" html="required maxlength=50" />
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
