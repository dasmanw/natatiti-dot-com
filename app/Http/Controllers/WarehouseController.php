<?php

namespace App\Http\Controllers;

use App\DataTables\WarehouseDataTable;
use App\Http\Requests\Warehouse\StoreRequest;
use App\Http\Requests\Warehouse\UpdateRequest;
use App\Interfaces\Services\WarehouseServiceInterface;
use App\Models\City;
use App\Models\Warehouse;
use App\Models\WarehouseDetail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class WarehouseController extends Controller
{
    public function __construct(
        private WarehouseServiceInterface $iWarehouseService
    ) {
    }

    public function create(): View
    {
        $cityIDs = WarehouseDetail::pluck('city_id');

        $data = [
            'cities' => City::whereNotIn('id', $cityIDs)->get(['id', 'name'])
        ];
        return view('content.warehouse.create', $data);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $attributes = $request->validated();
        $warehouse = $this->iWarehouseService->store($attributes);

        return to_route('warehouse.index')->with(
            $warehouse ? 'success' : 'error',
            $warehouse ? 'Warehouse Added!' : 'Something Went Wrong!'
        );
    }

    public function index(WarehouseDataTable $dataTable)
    {
        return $dataTable->render('content.warehouse.index');
    }

    public function show(Warehouse $warehouse)
    {
        $data = [
            'warehouse' => $warehouse
        ];

        return view('content.warehouse.show', $data);
    }

    public function edit(Warehouse $warehouse): View
    {
        $warehouse->load('cities');
        $cityIDs = WarehouseDetail::whereNot('warehouse_id', $warehouse->id)->pluck('city_id');

        $data = [
            'warehouse' => $warehouse,
            'cities' => City::whereNotIn('id', $cityIDs)->get(['id', 'name'])
        ];

        return view('content.warehouse.edit', $data);
    }

    public function update(UpdateRequest $request, Warehouse $warehouse): RedirectResponse
    {
        $attributes = $request->validated();
        $updated = $this->iWarehouseService->modify($warehouse, $attributes);

        return to_route('warehouse.index')->with(
            $updated ? 'success' : 'error',
            $updated ? 'Warehouse Updated!' : 'Something Went Wrong!'
        );
    }

    public function destroy(Warehouse $warehouse)
    {
        $deleted = $this->iWarehouseService->delete($warehouse);

        return to_route('warehouse.index')->with(
            $deleted ? 'success' : 'error',
            $deleted ? 'Warehouse Deactivated!' : 'Something Went Wrong!'
        );
    }

    public function restore(Warehouse $warehouse)
    {
        $restored = $this->iWarehouseService->restore($warehouse);

        return to_route('warehouse.index')->with(
            $restored ? 'success' : 'error',
            $restored ? 'Warehouse Reactivated!' : 'Something Went Wrong!'
        );
    }
}
