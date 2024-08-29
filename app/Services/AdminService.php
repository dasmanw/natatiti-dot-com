<?php

namespace App\Services;

use App\Interfaces\Services\AdminServiceInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Models\User;
use App\Notifications\UserAdded;
use Dynamicbits\Larabit\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminService extends BaseService implements AdminServiceInterface
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

        $role = User::ADMIN;
        // $password = Str::random(10);
        // $attributes['password'] = $password;
        $admin = $this->iUserService->create($attributes);
        $admin->assignRole($role);

        // $notification = new UserAdded($admin->email, $password, $role);
        // $admin->notify($notification);

        DB::commit();

        return $admin;
    }
}
