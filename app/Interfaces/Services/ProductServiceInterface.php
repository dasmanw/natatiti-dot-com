<?php

namespace App\Interfaces\Services;

use App\Models\Product;
use Dynamicbits\Larabit\Interfaces\Services\BaseServiceInterface;
use Illuminate\Database\Eloquent\Model;

interface ProductServiceInterface extends BaseServiceInterface
{
    public function store(array $attributes): Product;
    public function modify(Model $model, array $attributes): bool;
    public function indexForSalesman(array $parameters): array;
}
