<?php

namespace BinaryCastle\Boilerplate\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => 'required|file',
            'is_last' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
