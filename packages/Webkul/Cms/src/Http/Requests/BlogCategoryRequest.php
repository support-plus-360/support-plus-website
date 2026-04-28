<?php

namespace Webkul\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $blogCategoryId = $this->route('id');

        return [
            'slug'         => [
                'required',
                'string',
                'max:255',
                Rule::unique('cms_blog_categories', 'slug')->ignore($blogCategoryId),
            ],
            'name'         => ['required', 'string', 'max:255'],
            'is_active'    => ['nullable', 'boolean'],
            'order'        => ['nullable', 'integer', 'min:0'],
            'company_id'   => ['nullable', 'integer', 'exists:companies,id'],
            'translations' => ['required', 'array'],
            'translations.*.title' => ['required', 'string', 'max:255'],
            'translations.*.description' => ['nullable', 'string'],
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
