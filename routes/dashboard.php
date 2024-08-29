<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesmanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::middleware('language.manager')->group(function () {

    Route::view('/', 'content.dashboard.index')->name('home');


    Route::prefix('users')->name('users.')->group(function () {
    });

    Route::get('/language-change/{lang}', [CustomController::class, 'langChange'])->name('language.change');

    Route::prefix('/settings')->name('settings.')->group(function () {
        Route::get('/account', [SettingController::class, 'account'])->name('account');
        Route::put('/account', [SettingController::class, 'accountUpdate'])->name('account.update');
        Route::get('/password', [SettingController::class, 'password'])->name('password');
        Route::put('/password', [SettingController::class, 'passwordUpdate'])->name('password.update');
    });

    Route::middleware('permission:vendor.*')->prefix('vendors')->name('vendor.')->group(function () {
        Route::get('/', [VendorController::class, 'index'])->name('index');
        Route::get('/create', [VendorController::class, 'create'])->name('create');
        Route::post('/', [VendorController::class, 'store'])->name('store');
        Route::get('/{vendor}', [VendorController::class, 'show'])->name('show')->withTrashed();
        Route::get('/{vendor}/edit', [VendorController::class, 'edit'])->name('edit')->withTrashed();
        Route::put('/{vendor}', [VendorController::class, 'update'])->name('update');
        Route::delete('/{vendor}', [VendorController::class, 'destroy'])->name('destroy');
        Route::post('/{vendor}', [VendorController::class, 'restore'])->name('restore')->withTrashed();
    });

    Route::middleware('permission:admin.*')->prefix('admins')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{admin}', [AdminController::class, 'show'])->name('show')->withTrashed();
        Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('edit')->withTrashed();
        Route::put('/{admin}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('destroy');
        Route::post('/{admin}', [AdminController::class, 'restore'])->name('restore')->withTrashed();
    });

    Route::middleware('permission:salesman.*')->prefix('salesmen')->name('salesman.')->group(function () {
        Route::get('/', [SalesmanController::class, 'index'])->name('index');
        Route::get('/create', [SalesmanController::class, 'create'])->name('create');
        Route::post('/', [SalesmanController::class, 'store'])->name('store');
        Route::get('/{salesman}', [SalesmanController::class, 'show'])->name('show')->withTrashed();
        Route::get('/{salesman}/edit', [SalesmanController::class, 'edit'])->name('edit')->withTrashed();
        Route::put('/{salesman}', [SalesmanController::class, 'update'])->name('update');
        Route::delete('/{salesman}', [SalesmanController::class, 'destroy'])->name('destroy');
        Route::post('/{salesman}', [SalesmanController::class, 'restore'])->name('restore')->withTrashed();
    });

    Route::middleware('permission:warehouse.*')->prefix('warehouses')->name('warehouse.')->group(function () {
        Route::get('/', [WarehouseController::class, 'index'])->name('index');
        Route::get('/create', [WarehouseController::class, 'create'])->name('create');
        Route::post('/', [WarehouseController::class, 'store'])->name('store');
        Route::get('/{warehouse}', [WarehouseController::class, 'show'])->name('show')->withTrashed();
        Route::get('/{warehouse}/edit', [WarehouseController::class, 'edit'])->name('edit')->withTrashed();
        Route::put('/{warehouse}', [WarehouseController::class, 'update'])->name('update');
        Route::delete('/{warehouse}', [WarehouseController::class, 'destroy'])->name('destroy');
        Route::post('/{warehouse}', [WarehouseController::class, 'restore'])->name('restore')->withTrashed();
    });

    Route::middleware('permission:category.*')->prefix('categories')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}', [CategoryController::class, 'show'])->name('show')->withTrashed();
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit')->withTrashed();
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        Route::post('/{category}', [CategoryController::class, 'restore'])->name('restore')->withTrashed();
    });

    Route::middleware('permission:product.*')->prefix('products')->name('product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show')->withTrashed();
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit')->withTrashed();
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
        Route::post('/{product}', [ProductController::class, 'restore'])->name('restore')->withTrashed();
    });
    Route::post('/file-import', [ProductController::class, 'file'])->name('file.post');
});
