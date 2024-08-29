<?php

namespace App\Http\Controllers;

use App\DataTables\ProductDataTable;
use App\Http\Requests\Product\FilterRequest;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Imports\ProductImport;
use App\Interfaces\Services\CategoryServiceInterface;
use App\Interfaces\Services\ProductServiceInterface;
use App\Interfaces\Services\VendorServiceInterface;
use App\Interfaces\Services\WarehouseServiceInterface;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function __construct(
        private ProductServiceInterface $iProductService,
        private VendorServiceInterface $iVendorService,
        private CategoryServiceInterface $iCategoryService,
        private WarehouseServiceInterface $iWarehouseService
    ) {
    }

    public function create(): View
    {
        $data = [
            'categories' => $this->iCategoryService->get(columns: ['id', 'name'], pagination: false),
            'warehouses' => $this->iWarehouseService->get(columns: ['id', 'name'], pagination: false)
        ];

        if (is_super_admin() || is_admin()) {
            $data['vendors'] = $this->iVendorService
                ->newQuery()->role(User::VENDOR)->get(['id', 'name']);
        }

        return view('content.product.create', $data);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $attributes = $request->validated();
        $product = $this->iProductService->store($attributes);

        return to_route('product.index')->with(
            $product ? 'success' : 'error',
            $product ? 'Product Added!' : 'Something Went Wrong!'
        );
    }

    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('content.product.index');
    }

    public function file(Request $request)
    {
        Excel::import(new ProductImport,$request->file('csv'));
             
        return back();
    }

    public function show(Product $product)
    {
        $data = [
            'product' => $product
        ];

        return view('content.product.show', $data);
    }

    public function edit(Product $product): View
    {
        $data = [
            'categories' => $this->iCategoryService->get(columns: ['id', 'name'], pagination: false),
            'warehouses' => $this->iWarehouseService->get(columns: ['id', 'name'], pagination: false),
            'product' => $product
        ];

        return view('content.product.edit', $data);
    }

    public function update(UpdateRequest $request, Product $product): RedirectResponse
    {
        $attributes = $request->validated();
        $updated = $this->iProductService->modify($product, $attributes);

        return to_route('product.index')->with(
            $updated ? 'success' : 'error',
            $updated ? 'Product Updated!' : 'Something Went Wrong!'
        );
    }

    public function destroy(Product $product)
    {
        $deleted = $this->iProductService->delete($product);

        return to_route('product.index')->with(
            $deleted ? 'success' : 'error',
            $deleted ? 'Product Deactivated!' : 'Something Went Wrong!'
        );
    }

    public function restore(Product $product)
    {
        $restored = $this->iProductService->restore($product);

        return to_route('product.index')->with(
            $restored ? 'success' : 'error',
            $restored ? 'Product Reactivated!' : 'Something Went Wrong!'
        );
    }

    public function indexForSalesman(FilterRequest $request)
    {
        $data = $this->iProductService->indexForSalesman($request->validated());

        return view('content.product.salesman.index', $data);
    }

    public function ajaxShow(Product $product){
        return response()->json(['prices' => $product->prices]);
    }
}
