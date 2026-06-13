<?php

namespace Webkul\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:255'],
            'is_active'  => ['nullable', 'boolean'],
            'company_id' => ['nullable', 'integer', 'exists:companies,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => (bool) $this->boolean('is_active'),
        ]);
    }
}
