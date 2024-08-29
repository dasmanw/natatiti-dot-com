<?php

namespace App\Interfaces\Services;

use App\Models\Reservation;
use App\Models\ReservationDetail;
use Dynamicbits\Larabit\Interfaces\Services\BaseServiceInterface;
use Illuminate\Database\Eloquent\Model;

interface ReservationServiceInterface extends BaseServiceInterface
{
    public function checkout(array $attributes): Model;
    public function modify(Reservation $reservation, array $attributes): bool;
    public function destroyDetail(ReservationDetail $reservationDetail);
    public function destroy(Reservation $reservation): ?bool;
    public function addProduct(array $attributes): ReservationDetail;
}
