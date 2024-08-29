<?php

namespace App\Repositories;

use App\Interfaces\Repositories\WarehouseRepositoryInterface;
use App\Models\Warehouse;
use Dynamicbits\Larabit\Repositories\BaseRepository;

class WarehouseRepository extends BaseRepository implements WarehouseRepositoryInterface
{
    public function __construct(Warehouse $Warehouse)
    {
        parent::__construct($Warehouse);
    }
}
