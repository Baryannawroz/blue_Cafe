<?php

namespace BinaryCastle\Boilerplate\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    protected $base_rules = [
        'name' => 'required|string|unique:roles|max:40|min:5',
        'permissions' => 'required|array|min:1',
        'side_nav' => 'required|json'
    ];

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return match ($this->method()) {
            'PUT' => $this->updateRules(),
            default => $this->base_rules,
        };
    }

    private function updateRules(): array
    {
        $this->base_rules['name'] = 'required|string|max:40|min:5|unique:roles,id,' . $this->route('role');
        return $this->base_rules;
    }

}
