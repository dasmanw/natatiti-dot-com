<?php

namespace App\Services;

use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Interfaces\Services\ProductServiceInterface;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ReservationDetail;
use Carbon\Carbon;
use Dynamicbits\Larabit\Services\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductService extends BaseService implements ProductServiceInterface
{
    public function __construct(
        private ProductRepositoryInterface $iProductRepository,
        private Product $Product
    ) {
        parent::__construct($Product);
    }

    public function store(array $attributes): Product
    {
        foreach (Product::$priceTypes as $price) {
            $field = strtolower(str_replace(' ', '_', $price));
            $priceTypes[$field] = $attributes[$field];
        }
        $attributes['prices'] = json_encode($priceTypes);
        $attributes['warehouse_id'] = isset($attributes['warehouse']) ? $attributes['warehouse'] : null;
        $attributes['category_id'] = isset($attributes['category']) ? $attributes['category'] : null;
        $attributes['vendor_id'] = isset($attributes['vendor']) ? $attributes['vendor'] : null;

        DB::beginTransaction();

        $product = $this->iProductRepository->create($attributes);

        $product->addMedia($attributes['image'])->toMediaCollection('images');

        DB::commit();

        return $product;
    }

    public function modify(Model $model, array $attributes): bool
    {
        foreach (Product::$priceTypes as $price) {
            $field = strtolower(str_replace(' ', '_', $price));
            $priceTypes[$field] = $attributes[$field];
        }
        $attributes['prices'] = json_encode($priceTypes);
        $attributes['warehouse_id'] = isset($attributes['warehouse']) ? $attributes['warehouse'] : null;
        $attributes['category_id'] = isset($attributes['category']) ? $attributes['category'] : null;

        DB::beginTransaction();

        $updated = $this->iProductRepository->update($model, $attributes);

        if (isset($attributes['image'])) {
            $model->clearMediaCollection('images');
            $model->addMedia($attributes['image'])->toMediaCollection('images');
        }

        DB::commit();

        return $updated;
    }

    public function indexForSalesman(array $parameters): array
    {
        $pickup_date_time = $parameters['pickup_date_time'];
        $dropoff_date_time = $parameters['dropoff_date_time'];
        $parsedPickupDateTime = Carbon::parse($pickup_date_time)->subMinute()->toDateTimeLocalString();
        $parsedDropoffDateTime = Carbon::parse($dropoff_date_time)->subMinute()->toDateTimeLocalString();
        $location = $parameters['location'];
        $categories = Category::all(['id', 'name']);

        // Querying for products that are reserved based on various criteria

        // Query reservations where the pickup date time falls before or is equal to the requested pickup date time
        // and the dropoff date time falls after or is equal to the requested pickup date time
        $reservedProducts = ReservationDetail::where('pickup_date_time', '<=', $parsedPickupDateTime)
            ->where('dropoff_date_time', '>=', $parsedPickupDateTime)
            // OR: Check if the pickup date time falls before or is equal to the requested dropoff date time
            // and the dropoff date time falls after or is equal to the requested dropoff date time
            ->orWhere('pickup_date_time', '<=', $parsedDropoffDateTime)
            ->where('dropoff_date_time', '>=', $parsedDropoffDateTime)
            // OR: Check if the pickup date time falls after or is equal to the requested pickup date time
            // and the dropoff date time falls before or is equal to the requested dropoff date time
            ->orWhere('pickup_date_time', '>=', $parsedPickupDateTime)
            ->where('dropoff_date_time', '<=', $parsedDropoffDateTime)
            // Check if the present date time falls within any reservation's duration
            ->get(['product_id', 'dropoff_date_time']);
        // Querying for added to cart same as above for reserved products
        $addedToCart = Cart::where('pickup_date_time', '<=', $parsedPickupDateTime)
            ->where('dropoff_date_time', '>=', $parsedPickupDateTime)
            ->orWhere('pickup_date_time', '<=', $parsedDropoffDateTime)
            ->where('dropoff_date_time', '>=', $parsedDropoffDateTime)
            ->orWhere('pickup_date_time', '>=', $parsedPickupDateTime)
            ->where('dropoff_date_time', '<=', $parsedDropoffDateTime)
            ->get(['product_id', 'dropoff_date_time']);
        $alreadyReserved = collect($reservedProducts)->merge($addedToCart);

        $categoryId = $parameters['category'] ?? null;
        count($parameters) == 3
            ? $products = $this->searchProducts($location, $parameters)
            : $products = $this->filterProductsByCategory($location, $categoryId, $parameters);

        $products->whereIn('id', $alreadyReserved->pluck('product_id'))->map(function ($product) use ($alreadyReserved) {
            $available_from = $alreadyReserved->where('product_id', $product->id)->first()->dropoff_date_time;
            $product->available_from = Carbon::parse($available_from)->format('n/j/Y g:i A');
        });

        $data = [
            'pickup_date_time' => $pickup_date_time,
            'dropoff_date_time' => $dropoff_date_time,
            'location' => $location,
            'products' => $products,
            'categories' => $categories
        ];
        if ($categoryId != null) {
            $data['categoryId'] = $categoryId;
        }
        foreach (['height', 'width', 'length', 'name'] as $dimension)
            if (isset($parameters[$dimension]))
                $data[$dimension] = $parameters[$dimension];

        return $data;
    }

    private function searchProducts($location, $parameters)
    {
        if (str_contains($location, '_')) {
            $locationParts = explode('_', $location);
            $location = $locationParts[0];
        }
        return $this->iProductRepository->getByCriteria(
            criteria: ['warehouse_id' => $location],
            relations: ['media'],
            pagination: 20
        )->appends($parameters);
    }

    private function filterProductsByCategory($location, $categoryId, $parameters)
    {
        if (str_contains($location, '_')) {
            $locationParts = explode('_', $location);
            $location = $locationParts[0];
        }
        $criteria = [['warehouse_id', $location]];
        foreach (['height', 'width', 'length'] as $dimension)
            if (isset($parameters[$dimension]))
                $criteria[] = [$dimension, $parameters[$dimension]];
        if (isset($parameters['name']))
            $criteria[] = ['name', 'like', '%' . $parameters['name'] . '%'];
        if (isset($categoryId))
            $criteria[] = ['category_id', $categoryId];
        return $this->iProductRepository->getByCriteria(
            criteria: $criteria,
            relations: ['media'],
            pagination: 20
        )->appends($parameters);
    }
}
