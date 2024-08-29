<?php

namespace App\Interfaces\Repositories;

use Dynamicbits\Larabit\Interfaces\Repositories\BaseRepositoryInterface;

interface CartRepositoryInterface extends BaseRepositoryInterface
{
    public function empty(): ?bool;
}
