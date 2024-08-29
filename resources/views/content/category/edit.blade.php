@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Category')

@section('content')
    <x-breadcrumb>
        <li class="breadcrumb-item">{{ __('Category') }}</li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
    </x-breadcrumb>

    <x-page-heading>{{ __('Edit Category') }}</x-page-heading>

    <div class="row">
        <div class="col-md-12">
            @include('content.category.partials.nav')
            <div class="card mb-4">
                <h2 class="card-header h5">{{ __('Edit') }} {{ $category->name }}</h2>
                <hr class="my-0" />
                <div class="card-body">
                    <x-form action="{{ route('category.update', $category) }}" method="PUT">
                        <div class="row mb-3">
                            <x-input-responsive class="col-lg-3" name="name" value="{{ $category->name }}"
                                html="required maxlength=50" />
                            <x-textarea-responsive class="col-lg-9" name="description"
                                value="{{ $category->description }}" />
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
