<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CartRepositoryInterface;
use App\Models\Cart;
use Dynamicbits\Larabit\Repositories\BaseRepository;

class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    public function __construct(Cart $Cart)
    {
        parent::__construct($Cart);
    }

    public function empty(): ?bool
    {
        return $this->newQuery()->where('salesman_id', auth()->id())->delete();
    }
}
