<?php

namespace App\Interfaces\Services;

use Dynamicbits\Larabit\Interfaces\Services\BaseServiceInterface;

interface AdminServiceInterface extends BaseServiceInterface
{
    public function store(array $attributes);
}
