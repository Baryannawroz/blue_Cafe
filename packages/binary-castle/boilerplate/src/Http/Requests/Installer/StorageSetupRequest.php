<?php

namespace BinaryCastle\Boilerplate\Http\Requests\Installer;

use Illuminate\Foundation\Http\FormRequest;

class StorageSetupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'storage_type' => 'required|string|in:public,s3',
            's3_region' => 'required_if:storage_type,s3',
            's3_key' => 'required_if:storage_type,s3',
            's3_bucket' => 'required_if:storage_type,s3',
            's3_url' => 'required_if:storage_type,s3',
            's3_endpoint' => 'required_if:storage_type,s3',
            's3_secret' => 'required_if:storage_type,s3',
        ];
    }
}
