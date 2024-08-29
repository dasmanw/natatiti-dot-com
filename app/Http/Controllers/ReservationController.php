<?php

namespace App\Http\Controllers;

use App\DataTables\ReservationDataTable;
use App\Http\Requests\Reservation\AddProduct;
use App\Http\Requests\Reservation\StoreRequest;
use App\Http\Requests\Reservation\UpdateRequest;
use App\Interfaces\Services\CartServiceInterface;
use App\Interfaces\Services\ProductServiceInterface;
use App\Interfaces\Services\ReservationServiceInterface;
use App\Models\Reservation;
use App\Models\ReservationDetail;
use App\Models\WarehouseDetail;
use Flasher\Laravel\Http\Request;

class ReservationController extends Controller
{
    public function __construct(
        private ReservationServiceInterface $iReservationService,
        private CartServiceInterface $iCarService,
        private ProductServiceInterface $iProductService
    ) {
    }

    public function checkout(StoreRequest $request)
    {
        $attributes = $request->validated();

        $reservation = $this->iReservationService->checkout($attributes);

        return to_route(array_key_exists('invoice', $attributes) ? 'reservation.invoice' : 'reservation.index'
        , array_key_exists('invoice', $attributes) ? ['reservation' => $reservation->id] : [])->with(
            $reservation ? 'success' : 'error',
            $reservation ? 'Reservation Successful!' : 'Something Went Wrong!'
        );
    }

    public function create()
    {
        $this->iCarService->empty();

        $data = [
            'warehouseDetails' => WarehouseDetail::with('city:id,governorate_id,name', 'city.governorate:id,name')
                ->get()
                ->groupBy('city.governorate.name')
        ];

        return view('content.reservation.create', $data);
    }

    public function index(ReservationDataTable $dataTable)
    {
        return $dataTable->render('content.reservation.index');
    }

    public function edit(Reservation $reservation)
    {

        $reservation->load('reservation_details', 'reservation_details.product', 'reservation_details.product.media');

        $parameters = [
            'pickup_date_time' => $reservation->pickup_date_time,
            'dropoff_date_time' => $reservation->dropoff_date_time,
            'location' => $reservation->reservation_details[0]->product->warehouse_id
        ];
        $products = $this->iProductService->indexForSalesman($parameters);

        $data = [
            'reservation' => $reservation,
            'products' => $products['products']->whereNull('available_from')
        ];

        return view('content.reservation.edit', $data);
    }

    public function invoice(Reservation $reservation){
        $reservation->load('reservation_details.product.media', 'salesman');
        $data = [
            'reservation' => $reservation,
        ];

        return view('content.reservation.invoice', $data);
    }

    public function update(UpdateRequest $request, Reservation $reservation)
    {
        $attributes = $request->validated();
        $updated = $this->iReservationService->modify($reservation, $attributes);

        return to_route('reservation.index')->with(
            $updated ? 'success' : 'error',
            $updated ? 'Reservation Updated!' : 'Something Went Wrong!'
        );
    }

    public function destroyReservationDetail(ReservationDetail $reservationDetail)
    {
        $deleted = $this->iReservationService->destroyDetail($reservationDetail);

        if (is_string($deleted)) {
            $key = 'error';
            $message = $deleted;
        } else {
            $key = 'success';
            $message = $deleted ? 'Product Removed!' : 'Something Went Wrong';
        }

        return back()->with($key, $message);
    }

    public function destroy(Reservation $reservation)
    {
        $this->iReservationService->destroy($reservation);
        return back()->with('success', 'Reservation Deleted');
    }

    public function addProduct(AddProduct $request)
    {
        $attributes = $request->validated();

        $this->iReservationService->addProduct($attributes);

        return back()->with('success', 'Product Added to Reservation');
    }
}
