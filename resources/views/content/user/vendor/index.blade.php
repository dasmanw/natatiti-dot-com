@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Vendor Listing')

@section('content')
    <x-breadcrumb>
        <li class="breadcrumb-item">{{ __('Users') }}</li>
        <li class="breadcrumb-item">{{ __('Vendor') }}</li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Listing') }}</li>
    </x-breadcrumb>

    <x-page-heading>{{ __('Vendor Listing') }}</x-page-heading>

    <div class="row">
        <div class="col-md-12">
            @include('content.user.vendor.partials.nav')
            <div class="card mb-4">
                <h2 class="card-header h5">{{ __('Listing') }}</h2>
                <hr class="my-0" />
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link href="{{ asset('vendor/datatables/datatables.min.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
