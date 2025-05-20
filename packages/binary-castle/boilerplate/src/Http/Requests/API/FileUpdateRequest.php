<?php

namespace BinaryCastle\Boilerplate\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class FileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'alt' => 'nullable|string',
            'caption' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
