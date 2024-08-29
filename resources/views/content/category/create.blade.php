@extends('layouts/contentNavbarLayout')

@section('title', 'Add Category')

@section('content')
    <x-breadcrumb>
        <li class="breadcrumb-item">{{ __('Category') }}</li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Add') }}</li>
    </x-breadcrumb>

    <x-page-heading>{{ __('Add Category') }}</x-page-heading>

    <div class="row">
        <div class="col-md-12">
            @include('content.category.partials.nav')
            <div class="card mb-4">
                <h5 class="card-header">{{ __('Add') }}</h5>
                <hr class="my-0" />
                <div class="card-body">
                    <x-form action="{{ route('category.store') }}">
                        <div class="row mb-3">
                            <x-input-responsive class="col-lg-3" name="name" html="required maxlength=50" />
                            <x-textarea-responsive class="col-lg-9" name="description" />
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
