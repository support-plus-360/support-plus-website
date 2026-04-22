<?php

namespace Webkul\Company\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $companyId = $this->route('id');

        return [
            'name'         => [
                'required',
                'string',
                'max:255',
                Rule::unique('companies', 'name')->ignore($companyId),
            ],
            'short_name' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable'],
            'configs' => ['nullable'],
            'is_active' => ['nullable', 'boolean'],

            'address.email' => ['nullable', 'email', 'max:255'],
            'address.phone' => ['nullable', 'string', 'max:50'],
            'address.location' => ['nullable', 'string', 'max:255'],

            'configs.main_color' => ['nullable', 'string', 'max:20'],
            'configs.secondary_color' => ['nullable', 'string', 'max:20'],
            'configs.accent_color' => ['nullable', 'string', 'max:20'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $address = $this->input('address');
        if (is_string($address)) {
            $decoded = json_decode($address, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $address = $decoded;
            }
        }

        $configs = $this->input('configs');
        if (is_string($configs)) {
            $decoded = json_decode($configs, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $configs = $decoded;
            }
        }

        $address = $address === null ? [] : (array) $address;
        $configs = $configs === null ? [] : (array) $configs;

        $this->merge([
            'address' => array_intersect_key($address, array_flip(['email', 'phone', 'location'])),
            'configs' => array_intersect_key($configs, array_flip(['main_color', 'secondary_color', 'accent_color'])),
            'is_active' => (bool) $this->input('is_active'),
        ]);
    }
}

