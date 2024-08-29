<?php

namespace App\Services;

use App\Interfaces\Services\SalesmanServiceInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Models\User;
use App\Notifications\UserAdded;
use Dynamicbits\Larabit\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class SalesmanService extends BaseService implements SalesmanServiceInterface
{
    public function __construct(
        private UserServiceInterface $iUserService,
        private User $User
    ) {
        parent::__construct($User);
    }

    public function store(array $attributes)
    {
        DB::beginTransaction();

        $role = User::SALESMAN;
        // $password = Str::random(10);
        // $attributes['password'] = $password;
        $vendor = $this->iUserService->create($attributes);
        $vendor->assignRole($role);

        // $notification = new UserAdded($vendor->email, $password, $role);
        // $vendor->notify($notification);

        DB::commit();

        return $vendor;
    }
}
