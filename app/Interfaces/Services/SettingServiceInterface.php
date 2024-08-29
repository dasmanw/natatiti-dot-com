<?php

namespace App\Interfaces\Services;

interface SettingServiceInterface
{
    public function accountUpdate(array $attributes): ?bool;
    public function passwordUpdate(string $new_password): ?bool;
}
