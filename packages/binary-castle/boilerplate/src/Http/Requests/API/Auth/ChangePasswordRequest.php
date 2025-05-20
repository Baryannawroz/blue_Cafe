<?php

namespace BinaryCastle\Boilerplate\Http\Requests\API\Auth;


use BinaryCastle\Boilerplate\Rules\MatchCurrentPassword;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current_password' => ['required', new MatchCurrentPassword()],
            'password' => 'required|string|confirmed|min:6|max:20',
            'password_confirmation' => 'required|min:6|max:20',
        ];
    }
}
