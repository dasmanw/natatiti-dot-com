@extends('layouts/contentNavbarLayout')

@section('title', 'Add Product')

@section('content')
    <x-breadcrumb>
        <li class="breadcrumb-item">{{ __('Product') }}</li>
        <li class="breadcrumb-item active" aria-current="page">Add</li>
    </x-breadcrumb>

    <x-page-heading>Add Product</x-page-heading>

    <div class="row">
        <div class="col-md-12">
            @include('content.product.partials.nav')
            <div class="card mb-4">
                <h5 class="card-header">Add</h5>
                <hr class="my-0" />
                <div class="card-body">
                    <x-form action="{{ route('product.store') }}" multipart="true">
                        <div class="row mb-3">
                            @if (is_super_admin() || is_admin())
                                <x-select-responsive name="vendor" html="">
                                    <option value="" selected disabled>Select Vendor</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}"
                                            {{ old('vendor') == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}
                                        </option>
                                    @endforeach
                                </x-select-responsive>
                            @endif
                            <x-select-responsive name="warehouse" html="required">
                                <option value="" selected disabled>Select Warehouse</option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}"
                                        {{ old('warehouse') == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </x-select-responsive>
                            <x-select-responsive name="category" html="required">
                                <option value="" selected disabled>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                    </option>
                                @endforeach
                            </x-select-responsive>
                            <x-input-responsive class="{{ is_super_admin() || is_admin() ? 'col-md-6' : 'col-lg-4' }}"
                                name="name" html="required maxlength=100" />
                            <x-input-responsive class="col-6 col-md-{{ is_super_admin() || is_admin() ? 2 : 3 }}"
                                name="length" type="number" html="min=1 maxlength=8" />
                            <x-input-responsive class="col-6 col-md-{{ is_super_admin() || is_admin() ? 2 : 3 }}"
                                name="height" type="number" html="min=1 maxlength=8" />
                            <x-input-responsive class="col-6 col-md-{{ is_super_admin() || is_admin() ? 2 : 3 }}"
                                name="width" type="number" html="min=1 maxlength=8" />
                            {{-- <x-input-responsive class="col-6 col-md-{{ is_super_admin() || is_admin() ? 2 : 3 }}"
                                name="quantity" type="number" value="1" html="min=1 maxlength=8" /> --}}
                            <x-textarea-responsive class="col-12" name="description" />
                            <div class="col-12 mb-3">
                                <label class="form-label" for="image">{{ __('Image') }}</label>
                                <input class="form-control @error('image') is-invalid @enderror" id="image"
                                    name="image" type="file" accept="image/png, image/jpeg" required />
                                <x-invalid-input error="image" />
                            </div>
                            <div class="col-12 mb-3">
                                <hr>
                            </div>
                            <h5>{{ __('Prices') }}</h5>
                            @foreach (App\Models\Product::$priceTypes as $price)
                                <x-input-responsive class="col-6 col-md-3"
                                    name="{{ str_replace(' ', '_', __(strtolower($price))) }}" type="number"
                                    html="required min=1 maxlength=8" />
                            @endforeach
                            <div class="col-md-3 col-lg-2 d-flex align-items-end">
                                <x-button class="primary btn-pinned mb-3">{{ __('Save') }}</x-button>
                            </div>
                        </div>
                    </x-form>
                </div>
            </div>
        </div>
    </div>
@endsection
