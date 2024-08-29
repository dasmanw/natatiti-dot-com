<?php

namespace App\Interfaces\Services;

use App\Models\Warehouse;
use Dynamicbits\Larabit\Interfaces\Services\BaseServiceInterface;

interface WarehouseServiceInterface extends BaseServiceInterface
{
    public function store(array $attributes): Warehouse;
    public function modify(Warehouse $warehouse, array $attributes): ?bool;
}
