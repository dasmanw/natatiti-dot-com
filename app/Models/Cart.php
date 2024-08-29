<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->salesman_id = auth()->id();
        });
    }

    protected $fillable = [
        'salesman_id',
        'product_id',
        'city_id',
        'price_type',
        'total',
        'net_total',
        'discount',
        'pickup_date_time',
        'dropoff_date_time',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
