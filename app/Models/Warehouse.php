<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Warehouse extends Model
{
    use HasFactory, CreatedUpdatedBy, SoftDeletes, HasTranslations;

    public $translatable = ['name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class, 'warehouse_details');
    }
}
