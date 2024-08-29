<?php

namespace App\Http\Controllers;

use App\DataTables\SalesmanDataTable;
use App\Http\Requests\Salesman\StoreRequest;
use App\Http\Requests\Salesman\UpdateRequest;
use App\Interfaces\Services\SalesmanServiceInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SalesmanController extends Controller
{
    public function __construct(
        private UserServiceInterface $iUserService,
        private  SalesmanServiceInterface $iSalesmanService
    ) {
    }

    public function create(): View
    {
        return view('content.user.salesman.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $attributes = $request->validated();
        $salesman = $this->iSalesmanService->store($attributes);

        return to_route('salesman.index')->with(
            $salesman ? 'success' : 'error',
            $salesman ? 'Salesman Added!' : 'Something Went Wrong!'
        );
    }

    public function index(SalesmanDataTable $dataTable)
    {
        return $dataTable->render('content.user.salesman.index');
    }

    public function show(User $salesman)
    {
        $data = [
            'salesman' => $salesman
        ];

        return view('content.user.salesman.show', $data);
    }

    public function edit(User $salesman): View
    {
        $data = [
            'salesman' => $salesman
        ];

        return view('content.user.salesman.edit', $data);
    }

    public function update(UpdateRequest $request, User $salesman): RedirectResponse
    {
        $attributes = $request->validated();
        $updated = $this->iSalesmanService->update($salesman, $attributes);

        return to_route('salesman.index')->with(
            $updated ? 'success' : 'error',
            $updated ? 'Salesman Updated!' : 'Something Went Wrong!'
        );
    }

    public function destroy(User $salesman)
    {
        $deleted = $this->iSalesmanService->delete($salesman);

        return to_route('salesman.index')->with(
            $deleted ? 'success' : 'error',
            $deleted ? 'Salesman Deactivated!' : 'Something Went Wrong!'
        );
    }

    public function restore(User $salesman)
    {
        $restored = $this->iSalesmanService->restore($salesman);

        return to_route('salesman.index')->with(
            $restored ? 'success' : 'error',
            $restored ? 'Salesman Reactivated!' : 'Something Went Wrong!'
        );
    }
}
