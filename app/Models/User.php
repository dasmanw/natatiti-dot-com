<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes, CreatedUpdatedBy;

    protected $table = 'accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'parent_id',
        'status',
        'phone_number',
        'address',
        'showable'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * User Roles
     */
    public const SUPER_ADMIN = 'Super Admin';
    public const ADMIN = 'Admin';
    public const VENDOR = 'Vendor';
    public const SALESMAN = 'Salesman';

    public static $roles = [
        self::SUPER_ADMIN,
        self::ADMIN,
        self::VENDOR,
        self::SALESMAN
    ];

    public static $registerableRoles = [
        self::ADMIN,
        self::VENDOR,
        self::SALESMAN
    ];

    /**
     * User Account Status
     */
    public const PENDING = 'Pending';
    public const APPROVED = 'Approved';
    public const DISAPPROVED = 'Disapproved';
    public const BANNED = 'Banned';

    public static $statuses = [
        self::PENDING,
        self::APPROVED,
        self::DISAPPROVED,
        self::BANNED
    ];

    public static $statusClass = [
        self::PENDING => 'bg-label-warning',
        self::APPROVED => 'bg-label-success',
        self::DISAPPROVED => 'bg-label-info',
        self::BANNED => 'bg-label-danger'
    ];

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'salesman_id', 'id');
    }
}
