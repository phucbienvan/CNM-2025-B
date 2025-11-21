<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class ResendVerifyEmailRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email|max:255|exists:users,email',
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'Email not found',
        ];
    }
}
