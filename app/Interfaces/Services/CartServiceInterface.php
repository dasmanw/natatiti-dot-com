<?php

namespace App\Interfaces\Services;

use App\Models\Cart;
use Dynamicbits\Larabit\Interfaces\Services\BaseServiceInterface;

interface CartServiceInterface extends BaseServiceInterface
{
    public function store(array $attributes): Cart;
    public function fetch(): array;
    public function empty(): ?bool;
}
