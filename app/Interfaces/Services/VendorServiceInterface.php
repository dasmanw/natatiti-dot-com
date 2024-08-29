<?php

namespace App\Interfaces\Services;

use Dynamicbits\Larabit\Interfaces\Services\BaseServiceInterface;

interface VendorServiceInterface extends BaseServiceInterface
{
    public function store(array $attributes);
}
