<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/modal-content', [CustomController::class, 'getContent'])->name('modal.content');
$roles = implode('|', [User::SUPER_ADMIN, User::ADMIN, User::SALESMAN]);
Route::middleware(['auth', 'role:' . $roles, 'language.manager'])->group(function () {
    Route::get('/products/list', [ProductController::class, 'indexForSalesman'])->name('product.list');
    Route::prefix('/carts')->name('cart.')->group(function () {
        Route::post('/', [CartController::class, 'store'])->name('store');
        Route::delete('/{cart}', [CartController::class, 'destroy'])->name('destroy');
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/check-out', [ReservationController::class, 'checkout'])->name('checkout');
    });
Route::get('/ajax/products/{product}/show', [ProductController::class, 'ajaxShow'])->name('ajax.product.show');

    Route::prefix('/reservations')->name('reservation.')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('index');
        Route::get('/create', [ReservationController::class, 'create'])->name('create');
        Route::post('/product/store', [ReservationController::class, 'addProduct'])->name('product.store');
        Route::get('/{reservation}/edit', [ReservationController::class, 'edit'])->name('edit');
        Route::get('/{reservation}/invoice', [ReservationController::class, 'invoice'])->name('invoice');
        Route::put('/{reservation}/update', [ReservationController::class, 'update'])->name('update');
        Route::delete('/{reservation}/destroy', [ReservationController::class, 'destroy'])->name('destroy');
    });
    Route::delete('/reservation-details/{reservationDetail}', [ReservationController::class, 'destroyReservationDetail'])->name('reservation-detail.destroy');
});
