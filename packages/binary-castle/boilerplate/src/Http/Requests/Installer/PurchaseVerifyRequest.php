<?php

namespace BinaryCastle\Boilerplate\Http\Requests\Installer;

use BinaryCastle\Boilerplate\Rules\VerifyPurchaseCode;
use Illuminate\Foundation\Http\FormRequest;

class PurchaseVerifyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'purchase_code' => ['required', 'string', new VerifyPurchaseCode]
        ];
    }
}
