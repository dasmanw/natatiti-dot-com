<?php

namespace App\Services;

use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Models\User;
use Dynamicbits\Larabit\Services\BaseService;

class UserService extends BaseService implements UserServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $iUserRepository,
        private User $User
    ) {
        parent::__construct($User);
    }
}
