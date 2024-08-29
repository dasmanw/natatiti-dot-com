<?php

namespace App\Http\Controllers;

use App\DataTables\CategoryDataTable;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Interfaces\Services\CategoryServiceInterface;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryServiceInterface $iCategoryService
    ) {
    }

    public function create(): View
    {
        return view('content.category.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $attributes = $request->validated();
        $category = $this->iCategoryService->create($attributes);

        return to_route('category.index')->with(
            $category ? 'success' : 'error',
            $category ? 'Category Added!' : 'Something Went Wrong!'
        );
    }

    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('content.category.index');
    }

    public function show(Category $category)
    {
        $data = [
            'category' => $category
        ];

        return view('content.category.show', $data);
    }

    public function edit(Category $category): View
    {
        $data = [
            'category' => $category
        ];

        return view('content.category.edit', $data);
    }

    public function update(UpdateRequest $request, Category $category): RedirectResponse
    {
        $attributes = $request->validated();
        $updated = $this->iCategoryService->update($category, $attributes);

        return to_route('category.index')->with(
            $updated ? 'success' : 'error',
            $updated ? 'Category Updated!' : 'Something Went Wrong!'
        );
    }

    public function destroy(Category $category)
    {
        $deleted = $this->iCategoryService->delete($category);

        return to_route('category.index')->with(
            $deleted ? 'success' : 'error',
            $deleted ? 'Category Deactivated!' : 'Something Went Wrong!'
        );
    }

    public function restore(Category $category)
    {
        $restored = $this->iCategoryService->restore($category);

        return to_route('category.index')->with(
            $restored ? 'success' : 'error',
            $restored ? 'Category Reactivated!' : 'Something Went Wrong!'
        );
    }
}
