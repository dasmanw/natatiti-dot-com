<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthRequest;
use App\Http\Requests\Auth\PasswordEmailRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Interfaces\Services\AuthServiceInterface;

class AuthController extends Controller
{
    public function __construct(
        private AuthServiceInterface $iAuthService
    ) {
    }

    public function create()
    {
        return view('content.auth.login');
    }

    public function store(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $remember = $request->has('remember');

        $authenticated = $this->iAuthService->auth($credentials, $remember);

        return $authenticated ? to_route('home') : back()->with('error', 'Invalid Credentials');
    }

    public function logout()
    {
        $this->iAuthService->logout();

        return to_route('login');
    }

    public function passwordRequest()
    {
        return view('content.auth.forgot-password-email');
    }

    public function passwordEmail(PasswordEmailRequest $request)
    {
        $email = $request->validated('email');
        $this->iAuthService->sendResetPasswordLink($email);

        return to_route('login')->with('success', 'Reset your password by clicking the reset link sent to your email.');
    }

    public function passwordReset(string $token, string $email)
    {
        $data = [
            'token' => $token,
            'email' => $email
        ];

        return view('content.auth.reset-password', $data);
    }

    public function passwordStore(PasswordResetRequest $request, string $token, string $email)
    {
        $updated =  $this->iAuthService->resetPassword($token, $email, $request->validated('password'));

        $key = $updated ? 'success' : 'error';
        $value = $updated ? 'Password has been updated' : 'Could not update password! Re-send reset link and try again';

        return to_route('login')->with($key, $value);
    }
}
