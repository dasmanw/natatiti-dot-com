<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->salesman_id = auth()->id();
        });

        static::created(function ($model) {
            $reservation = sprintf('%03d', $model->id);
            $salesman = sprintf('%03d', $model->salesman_id);
            $model->code = "NTR-$reservation-$salesman";
            $model->save();
        });
    }

    protected $fillable = [
        'salesman_id',
        'city_id',
        'pickup_date_time',
        'dropoff_date_time',
        'name',
        'address',
        'comments',
        'email',
        'phone_number',
        'payment_method',
        'type',
        'prices',
        'total_discount',
        'sub_total',
        'grand_total',
    ];

    public const CASH_ON_DELIVERY = 'Cash On Delivery';
    public const KNET = 'KNET';

    public static $paymentMethods = [
        self::CASH_ON_DELIVERY,
        self::KNET
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function salesman(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function reservation_details(): HasMany
    {
        return $this->hasMany(ReservationDetail::class);
    }
}
