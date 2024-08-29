<?php

namespace App\Http\Controllers;

use App\DataTables\VendorDataTable;
use App\Http\Requests\Vendor\StoreRequest;
use App\Http\Requests\Vendor\UpdateRequest;
use App\Interfaces\Services\UserServiceInterface;
use App\Interfaces\Services\VendorServiceInterface;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VendorController extends Controller
{
    public function __construct(
        private UserServiceInterface $iUserService,
        private VendorServiceInterface $iVendorService
    ) {
    }

    public function create(): View
    {
        return view('content.user.vendor.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $attributes = $request->validated();
        $vendor = $this->iVendorService->store($attributes);

        return to_route('vendor.index')->with(
            $vendor ? 'success' : 'error',
            $vendor ? 'Vendor Added!' : 'Something Went Wrong!'
        );
    }

    public function index(VendorDataTable $dataTable)
    {
        return $dataTable->render('content.user.vendor.index');
    }

    public function show(User $vendor)
    {
        $data = [
            'vendor' => $vendor
        ];

        return view('content.user.vendor.show', $data);
    }

    public function edit(User $vendor): View
    {
        $data = [
            'vendor' => $vendor
        ];

        return view('content.user.vendor.edit', $data);
    }

    public function update(UpdateRequest $request, User $vendor): RedirectResponse
    {
        $attributes = $request->validated();
        $updated = $this->iVendorService->update($vendor, $attributes);

        return to_route('vendor.index')->with(
            $updated ? 'success' : 'error',
            $updated ? 'Vendor Updated!' : 'Something Went Wrong!'
        );
    }

    public function destroy(User $vendor)
    {
        $deleted = $this->iVendorService->delete($vendor);

        return to_route('vendor.index')->with(
            $deleted ? 'success' : 'error',
            $deleted ? 'Vendor Deactivated!' : 'Something Went Wrong!'
        );
    }

    public function restore(User $vendor)
    {
        $restored = $this->iVendorService->restore($vendor);

        return to_route('vendor.index')->with(
            $restored ? 'success' : 'error',
            $restored ? 'Vendor Reactivated!' : 'Something Went Wrong!'
        );
    }
}
