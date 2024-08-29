@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

@section('content')
    <x-breadcrumb>
    </x-breadcrumb>
    <x-page-heading>{{ __('Dashboard') }}</x-page-heading>
    <div class="d-grid h-75" style="place-content: center;">
        <h2 class="display-5">Welcome</h2>
    </div>
@endsection
