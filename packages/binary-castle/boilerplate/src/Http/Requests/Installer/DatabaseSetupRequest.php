<?php

namespace BinaryCastle\Boilerplate\Http\Requests\Installer;

use Illuminate\Foundation\Http\FormRequest;

class DatabaseSetupRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'driver' => 'required|string|in:mysql,pgsql',
            'host' => 'required|string',
            'port' => 'required|numeric',
            'username' => 'required|string|alpha_dash',
            'password' => 'nullable|string',
            'database' => 'required|string|alpha_dash'
        ];
    }
}
