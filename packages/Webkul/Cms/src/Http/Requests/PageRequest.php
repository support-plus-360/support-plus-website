<?php

namespace Webkul\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pageId = $this->route('id');

        return [
            'slug'         => [
                'required',
                'string',
                'max:255',
                Rule::unique('cms_pages', 'slug')->ignore($pageId),
            ],
            'name'         => ['required', 'string', 'max:255'],
            'is_active'    => ['nullable', 'boolean'],
            'order'        => ['nullable', 'integer', 'min:0'],
            'type'         => ['required', 'string', Rule::in(['page', 'service', 'case_study', 'industry'])],
            'status'       => ['required', 'string', Rule::in(['draft', 'published', 'archived'])],
            'published_at' => ['nullable', 'date'],
            'author_id'    => ['nullable', 'integer', 'exists:users,id'],

            'translations'                       => ['required', 'array'],
            'translations.*.title'               => ['required', 'string', 'max:255'],
            'translations.*.meta_description'    => ['nullable', 'string'],
            'translations.*.meta_keywords'       => ['nullable', 'string', 'max:255'],
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

