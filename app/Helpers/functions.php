<?php

use App\Models\User;

if (!function_exists('is_super_admin')) {
    function is_super_admin(): bool
    {
        return auth()->user()->hasRole(User::SUPER_ADMIN);
    }
}

if (!function_exists('is_admin')) {
    function is_admin(): bool
    {
        return auth()->user()->hasRole(User::ADMIN);
    }
}

if (!function_exists('is_vendor')) {
    function is_vendor(): bool
    {
        return auth()->user()->hasRole(User::VENDOR);
    }
}

if (!function_exists('is_salesman')) {
    function is_salesman(): bool
    {
        return auth()->user()->hasRole(User::SALESMAN);
    }
}
