<?php

namespace BinaryCastle\Boilerplate\Http\Requests\Installer;

use Illuminate\Foundation\Http\FormRequest;

class EmailSetupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'transport' => 'required|in:log,smtp',
        ];

        if ($this->input('transport') === 'smtp') {
            $rules = array_merge($rules, [
                'host' => 'required|string',
                'port' => 'required|numeric',
                'username' => 'required|string',
                'password' => 'required|string',
                'encryption' => 'nullable|in:ssl,tls,null',
                'mail_from_address' => 'required|email',
                'mail_from_name' => 'required|string',
            ]);
        }

        return $rules;
    }
}
