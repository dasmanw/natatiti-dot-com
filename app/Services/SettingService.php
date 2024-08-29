<?php

namespace App\Services;

use App\Interfaces\Services\SettingServiceInterface;
use App\Interfaces\Services\UserServiceInterface;

class SettingService implements SettingServiceInterface
{
    public function __construct(
        private UserServiceInterface $iUserService
    ) {
    }

    public function accountUpdate(array $attributes): ?bool
    {
        $user = $this->iUserService->findById(auth()->id());
        return $this->iUserService->update($user, $attributes);
    }

    public function passwordUpdate(string $new_password): ?bool
    {
        
    }
}
