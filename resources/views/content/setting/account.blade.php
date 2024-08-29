@extends('layouts/contentNavbarLayout')

@section('title', 'Settings - Account')

@section('content')
    <x-breadcrumb>
        <li class="breadcrumb-item">{{ __('Settings') }}</li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Account') }}</li>
    </x-breadcrumb>

    <x-page-heading>{{ __('Account') }}</x-page-heading>

    <div class="row">
        <div class="col-md-12">
            @include('content.setting.partials.nav')
            <div class="card mb-4">
                <h5 class="card-header">{{ __('Profile Details') }}</h5>
                <!-- Account -->
                {{-- <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img class="d-block rounded" id="uploadedAvatar" src="../assets/img/avatars/1.png"
                                alt="user-avatar" height="100" width="100" />
                            <div class="button-wrapper">
                                <label class="btn btn-primary me-2 mb-4" for="upload" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input class="account-file-input" id="upload" type="file" hidden
                                        accept="image/png, image/jpeg" />
                                </label>
                                <button class="btn btn-outline-secondary account-image-reset mb-4" type="button">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>

                                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                            </div>
                        </div>
                    </div> --}}
                <hr class="my-0" />
                <div class="card-body">
                    <x-form action="{{ route('settings.account.update') }}" method="put">
                        <div class="row mb-3">
                            <x-input-responsive name="name" value="{{ $user->name }}" />
                            <x-input-responsive name="email" type="email" value="{{ $user->email }}" html="disabled" />
                            <x-input-responsive name="role" value="{{ $user?->roles[0]?->name }}" html="disabled" />
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
