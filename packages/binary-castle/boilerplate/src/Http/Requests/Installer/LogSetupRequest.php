<?php

namespace BinaryCastle\Boilerplate\Http\Requests\Installer;

use Illuminate\Foundation\Http\FormRequest;

class LogSetupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'log_channel' => 'required|string|in:single,daily,slack',
            'slack_url' => 'required_if:log_channel,slack'
        ];
    }
}
