@extends('layouts/contentNavbarLayout')

@section('title', 'Add Warehouse')

@section('content')
    <x-breadcrumb>
        <li class="breadcrumb-item">{{ __('Warehouse') }}</li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Add') }}</li>
    </x-breadcrumb>

    <x-page-heading>{{ __('Add Warehouse') }}</x-page-heading>

    <div class="row">
        <div class="col-md-12">
            @include('content.warehouse.partials.nav')
            <div class="card mb-4">
                <h5 class="card-header">{{ __('Add') }}</h5>
                <hr class="my-0" />
                <div class="card-body">
                    <x-form action="{{ route('warehouse.store') }}">
                        <div class="row mb-3">
                            <x-input-responsive class="col-lg-3" name="name" html="required maxlength=50" />
                            <x-input-responsive class="col-lg-9" name="address" html="required maxlength=255" />
                            <div class="col-12 mb-3">
                                <label class="form-label" for="cities">{{ __('Cities') }}</label>
                                <select class="@error('cities') invalid @enderror" id="cities" name="cities[]" multiple>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                <x-invalid-input error="cities" />
                                <x-invalid-input error="cities.*" />
                            </div>
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
@push('styles')
    <link href="{{ asset('vendor/slimselect/slimselect.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('vendor/slimselect/slimselect.min.js') }}"></script>
    <script type="module">
        new SlimSelect({
            settings: {
                placeholderText: 'Select Cities',
            },
            select: '#cities',
        })
    </script>
@endpush
