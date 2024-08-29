<?php

namespace App\Http\Controllers;

use App\DataTables\AdminDataTable;
use App\Http\Requests\Admin\StoreRequest;
use App\Http\Requests\Admin\UpdateRequest;
use App\Interfaces\Services\AdminServiceInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{

    public function __construct(
        private UserServiceInterface $iUserService,
        private AdminServiceInterface $iAdminService
    ) {
    }

    public function create(): View
    {
        return view('content.user.admin.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $attributes = $request->validated();
        $admin = $this->iAdminService->store($attributes);

        return to_route('admin.index')->with(
            $admin ? 'success' : 'error',
            $admin ? 'Admin Added!' : 'Something Went Wrong!'
        );
    }

    public function index(AdminDataTable $dataTable)
    {
        return $dataTable->render('content.user.admin.index');
    }

    public function show(User $admin)
    {
        $data = [
            'admin' => $admin
        ];

        return view('content.user.admin.show', $data);
    }

    public function edit(User $admin): View
    {
        $data = [
            'admin' => $admin
        ];

        return view('content.user.admin.edit', $data);
    }

    public function update(UpdateRequest $request, User $admin): RedirectResponse
    {
        $attributes = $request->validated();
        $updated = $this->iAdminService->update($admin, $attributes);

        return to_route('admin.index')->with(
            $updated ? 'success' : 'error',
            $updated ? 'Admin Updated!' : 'Something Went Wrong!'
        );
    }

    public function destroy(User $admin)
    {
        $deleted = $this->iAdminService->delete($admin);

        return to_route('admin.index')->with(
            $deleted ? 'success' : 'error',
            $deleted ? 'Admin Deactivated!' : 'Something Went Wrong!'
        );
    }

    public function restore(User $admin)
    {
        $restored = $this->iAdminService->restore($admin);

        return to_route('admin.index')->with(
            $restored ? 'success' : 'error',
            $restored ? 'Admin Reactivated!' : 'Something Went Wrong!'
        );
    }
}
