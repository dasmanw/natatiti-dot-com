<?php

namespace App\Http\Requests\Setting;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', new MatchOldPassword],
            'new_password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'same:new_password']
        ];
    }
}
