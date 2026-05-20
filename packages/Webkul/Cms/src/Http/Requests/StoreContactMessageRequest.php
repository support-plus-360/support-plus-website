<?php

namespace Webkul\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            // 'company_id' => ['required', 'integer', 'exists:companies,id'],
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255'],
            'phone'      => ['required', 'string', 'max:64'],
            'message'    => ['required', 'string', 'max:10000'],
        ];
    }
}