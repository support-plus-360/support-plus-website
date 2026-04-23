<?php

namespace Webkul\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $itemId = $this->route('id');

        return [
            'section_id'   => ['required', 'exists:cms_sections,id'],
            'type'         => ['required', 'string', Rule::in(['default', 'card', 'feature', 'testimonial', 'industry'])],
            'settings'     => ['nullable', 'array'],
            'is_active'    => ['nullable', 'boolean'],
            'order'        => ['nullable', 'integer', 'min:0'],
			'company_id'   => ['nullable', 'integer', 'exists:companies,id'],

	'translations' => ['required', 'array'],
	'translations.*.title' => ['required', 'string', 'max:255'],
	'translations.*.sub_title' => ['nullable', 'string'],
	'translations.*.content' => ['nullable', 'string'],
	'translations.*.icon' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => (bool) $this->boolean('is_active'),
            'order'     => $this->input('order') === null ? 0 : (int) $this->input('order'),
        ]);
    }
}

