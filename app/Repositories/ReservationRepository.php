<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ReservationRepositoryInterface;
use App\Models\Reservation;
use Dynamicbits\Larabit\Repositories\BaseRepository;

class ReservationRepository extends BaseRepository implements ReservationRepositoryInterface
{
    public function __construct(Reservation $Reservation)
    {
        parent::__construct($Reservation);
    }
}
