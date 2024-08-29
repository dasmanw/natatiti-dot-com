<?php

namespace App\Services;

use App\Interfaces\Repositories\CartRepositoryInterface;
use App\Interfaces\Services\CartServiceInterface;
use App\Interfaces\Services\ProductServiceInterface;
use App\Models\Cart;
use Carbon\Carbon;
use Dynamicbits\Larabit\Services\BaseService;

class CartService extends BaseService implements CartServiceInterface
{
    public function __construct(
        private CartRepositoryInterface $iCartRepository,
        private ProductServiceInterface $iProductService,
        private Cart $Cart
    ) {
        parent::__construct($Cart);
    }

    public function store(array $attributes): Cart
    {
        $discount = isset($attributes['discount']) ? $attributes['discount'] : 0;
        $productID = $attributes['product_id'];

        $prices = $this->iProductService->findById($productID, ['prices'])->prices;

        $pickupDate = Carbon::parse($attributes['pickup_date_time']);
        $dropoffDate = Carbon::parse($attributes['dropoff_date_time']);
        $reservedForDays = $dropoffDate->diffInDays($pickupDate) + 1;
        $selectedDays = str_replace(' Day', '', $attributes['price_type']);
        $additionalDays = max([$reservedForDays - $selectedDays, 0]);

        $prices = json_decode($prices);
        $additionalCharges = $additionalDays * $prices->per_day;
        $type = strtolower(str_replace(' ', '_', $attributes['price_type']));
        $total = $prices->$type + $additionalCharges;
        $netTotal = $total - $discount;

        $attributes['total'] = $total;
        $attributes['net_total'] = $netTotal;

        return $this->iCartRepository->create($attributes);
    }

    public function fetch(): array
    {
        $carts = auth()->user()->carts()->with('product:id,name,prices,image_link', 'product.media')->get();
        $calculations = collect([
            'discount' => $carts->sum('discount'),
            'sub_total' => $carts->sum('total')
        ]);

        $data = [
            'carts' => $carts,
            'calculations' => $calculations
        ];

        return $data;
    }

    public function empty(): ?bool
    {
        return $this->iCartRepository->empty();
    }
}
