<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\StoreRequest;
use App\Interfaces\Services\CartServiceInterface;
use App\Interfaces\Services\ProductServiceInterface;
use App\Models\Cart;

class CartController extends Controller
{
    public function __construct(
        private CartServiceInterface $iCartService,
        private ProductServiceInterface $iProductService
    ) {
    }

    public function index()
    {
        $data = $this->iCartService->fetch();

        return view('content.cart.index', $data);
    }

    public function store(StoreRequest $request)
    {
        $attributes = $request->validated();

        $cart = $this->iCartService->store($attributes);

        session()->flash('success', 'Product Added to Cart');

        return response()->json(['cart' => $cart]);
    }

    public function destroy(Cart $cart)
    {
        $this->iCartService->delete($cart);

        session()->flash('success', 'Product Removed from Cart');

        return back();
    }
}
