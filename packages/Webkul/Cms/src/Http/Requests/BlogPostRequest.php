<?php

namespace Webkul\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $blogPostId = $this->route('id');

        return [
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cms_blog_posts', 'slug')->ignore($blogPostId),
            ],
            'status' => ['required', 'string', Rule::in(['draft', 'published', 'archived'])],
            'published_at'         => ['nullable', 'date'],
            'is_featured'          => ['nullable', 'boolean'],
            'reading_time_minutes' => ['nullable', 'integer', 'min:0', 'max:32767'],
            'allow_comments'       => ['nullable', 'boolean'],
            'views_count'          => ['nullable', 'integer', 'min:0'],
            'canonical_url'        => ['nullable', 'string', 'max:2048'],
            'is_indexable'         => ['nullable', 'boolean'],
            'is_active'            => ['nullable', 'boolean'],
            'order'                => ['nullable', 'integer', 'min:0'],
            'author_id'   => ['nullable', 'integer', 'exists:users,id'],
            'company_id'  => ['nullable', 'integer', 'exists:companies,id'],

            'cms_blog_category_ids'   => ['required', 'array', 'min:1'],
            'cms_blog_category_ids.*' => ['integer', 'exists:cms_blog_categories,id'],

            'translations'                 => ['required', 'array'],
            'translations.*.title'         => ['required', 'string', 'max:255'],
            'translations.*.excerpt'       => ['nullable', 'string'],
            'translations.*.content'       => ['nullable', 'string'],
            'translations.*.meta_title'    => ['nullable', 'string', 'max:255'],
            'translations.*.meta_description' => ['nullable', 'string'],
            'translations.*.meta_keywords'    => ['nullable', 'string', 'max:512'],
            'translations.*.og_title'         => ['nullable', 'string', 'max:255'],
            'translations.*.og_description'   => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('cms_blog_category_id') && ! $this->filled('cms_blog_category_ids')) {
            $this->merge(['cms_blog_category_ids' => [(int) $this->input('cms_blog_category_id')]]);
        }

        $this->merge([
            'is_featured'    => (bool) $this->boolean('is_featured'),
            'allow_comments' => (bool) $this->boolean('allow_comments'),
            'is_indexable'   => (bool) $this->boolean('is_indexable'),
            'is_active'      => (bool) $this->boolean('is_active'),
            'order'          => $this->input('order') === null ? 0 : (int) $this->input('order'),
            'views_count'    => $this->input('views_count') === null || $this->input('views_count') === ''
                ? 0
                : (int) $this->input('views_count'),
            'company_id'            => $this->input('company_id') === null || $this->input('company_id') === ''
                ? null
                : (int) $this->input('company_id'),
            'published_at' => $this->input('published_at') ?: null,
        ]);
    }
}
