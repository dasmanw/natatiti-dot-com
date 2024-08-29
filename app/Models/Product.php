<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, CreatedUpdatedBy, SoftDeletes, InteractsWithMedia;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $vendor = sprintf('%03d', $model->vendor_id);
            $product = sprintf('%03d', $model->id);
            $model->code = "NP-$vendor-$product";
            $model->save();
        });
    }

    protected $fillable = [
        'vendor_id',
        'warehouse_id',
        'category_id',
        'code',
        'name',
        'length',
        'height',
        'width',
        'description',
        'quantity',
        'prices',
        'image_link',
        'is_available',
    ];

    public const _1_DAY = '1 Day';
    public const _3_DAY = '3 Day';
    public const _5_DAY = '5 Day';
    public const _PER_DAY = 'Per Day';

    public static $priceTypes = [
        self::_1_DAY,
        self::_3_DAY,
        self::_5_DAY,
        self::_PER_DAY,
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class)->withTrashed();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }
}
