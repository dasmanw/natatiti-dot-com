@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Product')

@section('content')
    <x-breadcrumb>
        <li class="breadcrumb-item">{{ __('Product') }}</li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
    </x-breadcrumb>

    <x-page-heading>{{ __('Edit Product') }}</x-page-heading>

    <div class="row">
        <div class="col-md-12">
            @include('content.product.partials.nav')
            <div class="card mb-4">
                <h5 class="card-header">{{ __('Edit') }}</h5>
                <hr class="my-0" />
                <div class="card-body">
                    <x-form action="{{ route('product.update', $product) }}" method="PUT" multipart="true">
                        <div class="row mb-3">
                            <x-select-responsive name="warehouse" html="">
                                <option value="" selected disabled>Select Warehouse</option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}"
                                        {{ $product->warehouse_id == $warehouse->id ? 'selected' : '' }}>
                                        {{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </x-select-responsive>
                            <x-select-responsive name="category" html="">
                                <option value="" selected disabled>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </x-select-responsive>
                            <x-input-responsive class="{{ is_super_admin() || is_admin() ? 'col-md-6' : 'col-lg-4' }}"
                                name="name" value="{{ $product->name }}" html="required maxlength=100" />
                            <x-input-responsive class="col-6 col-md-{{ is_super_admin() || is_admin() ? 2 : 3 }}"
                                name="length" type="number" value="{{ $product->length }}" html="min=1 maxlength=8" />
                            <x-input-responsive class="col-6 col-md-{{ is_super_admin() || is_admin() ? 2 : 3 }}"
                                name="height" type="number" value="{{ $product->height }}" html="min=1 maxlength=8" />
                            <x-input-responsive class="col-6 col-md-{{ is_super_admin() || is_admin() ? 2 : 3 }}"
                                name="width" type="number" value="{{ $product->width }}" html="min=1 maxlength=8" />
                            {{-- <x-input-responsive class="col-6 col-md-{{ is_super_admin() || is_admin() ? 2 : 3 }}"
                                name="quantity" type="number" value="1" html="min=1 maxlength=8" /> --}}
                            <x-textarea-responsive class="col-12" name="description" value="{{ $product->description }}" />
                            <div class="col-12 mb-3">
                                <label class="form-label" for="image">Image</label>
                                <input class="form-control @error('image') is-invalid @enderror" id="image"
                                    name="image" type="file" accept="image/png, image/jpeg" />
                                <x-invalid-input error="image" />
                            </div>
                            <div class="col-12 mb-3">
                                <hr>
                            </div>
                            <h5>{{ __('Prices') }}</h5>
                            @foreach (App\Models\Product::$priceTypes as $price)
                                @php
                                    $priceName = str_replace(' ', '_', strtolower($price));
                                @endphp
                                <x-input-responsive class="col-6 col-md-3" name="{{ $priceName }}" type="number"
                                    value="{{ json_decode($product->prices)->$priceName }}"
                                    html="required min=1 maxlength=8" />
                            @endforeach
                            <div class="col-12 mb-3">
                                <hr>
                            </div>
                            <div class="text-center">
                                <img src="{{ $product->getMedia('images')->first()?->getUrl() }}" alt="Image not found"
                                    style="max-height: 250px" loading="lazy">
                            </div>
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
