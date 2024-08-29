<?php

namespace App\Services;

use App\Interfaces\Repositories\ReservationRepositoryInterface;
use App\Interfaces\Services\CartServiceInterface;
use App\Interfaces\Services\ProductServiceInterface;
use App\Interfaces\Services\ReservationServiceInterface;
use App\Models\Reservation;
use App\Models\ReservationDetail;
use Carbon\Carbon;
use Dynamicbits\Larabit\Services\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReservationService extends BaseService implements ReservationServiceInterface
{
    public function __construct(
        private ReservationRepositoryInterface $iReservationRepository,
        private Reservation $Reservation,
        private CartServiceInterface $iCartService,
        private ProductServiceInterface $iProductService
    ) {
        parent::__construct($Reservation);
    }

    public function checkout(array $attributes): Model
    {
        $carts = $this->iCartService->newQuery()->where(['salesman_id' => auth()->id()])->get();

        if ($carts) {
            $discount = isset($attributes['total_discount']) ? $attributes['total_discount'] : 0;

            DB::beginTransaction();

            $attributes['sub_total'] = $carts->sum('total');
            $attributes['grand_total'] = $attributes['sub_total'] - $discount;
            $attributes['pickup_date_time'] = $carts->first()->pickup_date_time;
            $attributes['dropoff_date_time'] = $carts->first()->dropoff_date_time;
            $attributes['city_id'] = $carts->first()->city_id;

            $reservation = $this->iReservationRepository->create($attributes);

            $reservationDetail = [];
            foreach ($carts as $cart) {
                $reservationDetail[] = [
                    'reservation_id' => $reservation->id,
                    'product_id' => $cart->product_id,
                    'pickup_date_time' => $cart->pickup_date_time,
                    'dropoff_date_time' => $cart->dropoff_date_time,
                    'price' => $attributes['grand_total'],
                    'price_type' => $cart->price_type,
                ];
            }

            ReservationDetail::insert($reservationDetail);
            $this->iCartService->empty();

            DB::commit();

            return $reservation;
        }

        return false;
    }

    public function modify(Reservation $reservation, array $attributes): bool
    {
        $discount = isset($attributes['total_discount']) ? $attributes['total_discount'] : 0;

        $attributes['sub_total'] = $reservation->sub_total;
        $attributes['grand_total'] = $reservation->sub_total - $discount;

        return $this->iReservationRepository->update($reservation, $attributes);
    }

    public function destroyDetail(ReservationDetail $reservationDetail)
    {
        $count = ReservationDetail::where('reservation_id', $reservationDetail->reservation_id)->count();

        if ($count > 1) {
            $reservation = $this->iReservationRepository->findById($reservationDetail->reservation_id);
            $reservation->sub_total -= $reservationDetail->price;
            $reservation->grand_total = $reservation->sub_total - $reservation->total_discount;

            DB::beginTransaction();

            $reservation->update();
            $deleted = $reservationDetail->delete();

            DB::commit();

            return $deleted;
        }

        return 'Cannot Delete! A reservation must have at one product.';
    }

    public function destroy(Reservation $reservation): ?bool
    {
        DB::beginTransaction();

        ReservationDetail::where('reservation_id', $reservation->id)->delete();
        $deleted = $reservation->delete();

        DB::commit();

        return $deleted;
    }

    public function addProduct(array $attributes): ReservationDetail
    {
        $productID = $attributes['product'];

        $prices = $this->iProductService->findById($productID, ['prices'])->prices;

        $reservation = $this->iReservationRepository->findById($attributes['reservation_id']);

        $pickupDate = Carbon::parse($reservation->pickup_date_time);
        $dropoffDate = Carbon::parse($reservation->dropoff_date_time);
        $reservedForDays = $dropoffDate->diffInDays($pickupDate) + 1;
        $selectedDays = str_replace(' Day', '', $attributes['price_type']);
        $additionalDays = max([$reservedForDays - $selectedDays, 0]);

        $prices = json_decode($prices);
        $additionalCharges = $additionalDays * $prices->per_day;
        $type = strtolower(str_replace(' ', '_', $attributes['price_type']));
        $total = $prices->$type + $additionalCharges;

        $reservation->sub_total += $total;
        $reservation->grand_total += $total;

        DB::beginTransaction();

        $reservation->update();
        $reservationDetail = ReservationDetail::create([
            'reservation_id' => $attributes['reservation_id'],
            'product_id' => $productID,
            'pickup_date_time' => $reservation->pickup_date_time,
            'dropoff_date_time' => $reservation->dropoff_date_time,
            'price' => $total
        ]);

        DB::commit();

        return $reservationDetail;
    }
}
