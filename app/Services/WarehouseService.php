<?php

namespace App\Services;

use App\Interfaces\Repositories\WarehouseRepositoryInterface;
use App\Interfaces\Services\WarehouseServiceInterface;
use App\Models\Warehouse;
use App\Models\WarehouseDetail;
use Dynamicbits\Larabit\Services\BaseService;
use Illuminate\Support\Facades\DB;

class WarehouseService extends BaseService implements WarehouseServiceInterface
{
    public function __construct(
        private WarehouseRepositoryInterface $iWarehouseRepository,
        private Warehouse $Warehouse
    ) {
        parent::__construct($Warehouse);
    }

    public function store(array $attributes): Warehouse
    {
        DB::beginTransaction();

        $warehouse = $this->iWarehouseRepository->create($attributes);
        $warehouseDetails = [];
        foreach ($attributes['cities'] as $city_id) {
            $warehouseDetails[] = [
                'warehouse_id' => $warehouse->id,
                'city_id' => $city_id
            ];
        }
        WarehouseDetail::insert($warehouseDetails);

        DB::commit();

        return $warehouse;
    }

    public function modify(Warehouse $warehouse, array $attributes): ?bool
    {
        DB::beginTransaction();

        $updated = $this->iWarehouseRepository->update($warehouse, $attributes);
        $warehouseDetails = [];
        foreach ($attributes['cities'] as $city_id) {
            $warehouseDetails[] = [
                'warehouse_id' => $warehouse->id,
                'city_id' => $city_id
            ];
        }
        WarehouseDetail::insert($warehouseDetails);

        DB::commit();

        return $updated;
    }
}
