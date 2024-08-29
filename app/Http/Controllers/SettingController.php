<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setting\AccountUpdateRequest;
use App\Http\Requests\Setting\PasswordUpdateRequest;
use App\Interfaces\Services\SettingServiceInterface;
use App\Interfaces\Services\UserServiceInterface;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(
        private UserServiceInterface $iUserService,
        private SettingServiceInterface $iSettingService
    ) {
    }

    public function account()
    {
        $data = [
            'user' => $this->iUserService->findById(auth()->id())
        ];

        return view('content.setting.account', $data);
    }

    public function accountUpdate(AccountUpdateRequest $request)
    {
        $attributes = $request->validated();
        $updated = $this->iSettingService->accountUpdate($attributes);

        return back()->with(
            $updated ? 'success' : 'error',
            $updated ? 'Profile Updated' : 'Something Went Wrong'
        );
    }

    public function password()
    {
        return view('content.setting.password');
    }

    public function passwordUpdate(PasswordUpdateRequest $request)
    {
        $updated = $this->iSettingService->accountUpdate(['password' => $request->new_password]);

        return back()->with(
            $updated ? 'success' : 'error',
            $updated ? 'Password Updated' : 'Something Went Wrong'
        );
    }
}
