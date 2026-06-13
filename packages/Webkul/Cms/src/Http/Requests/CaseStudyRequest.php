<?php

namespace Webkul\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseStudyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cms_case_study_category_id' => ['nullable', 'integer', 'exists:cms_case_study_categories,id'],
            'city'                       => ['nullable', 'string', 'max:255'],
            'slug'                       => ['nullable', 'string', 'max:255', 'unique:cms_case_studies,slug,' . $this->route('id') . ',id,deleted_at,NULL'],
            'kpis_json'                  => ['nullable', 'string'],
            'kpis'                       => ['nullable', 'array'],
            'kpis.*.key'                 => ['nullable', 'string', 'max:255'],
            'kpis.*.value'               => ['nullable', 'string', 'max:255'],
            'rate'                       => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'is_active'                  => ['nullable', 'boolean'],
            'is_featured'                => ['nullable', 'boolean'],
            'order'                      => ['nullable', 'integer', 'min:0'],
            'company_id'                 => ['nullable', 'integer', 'exists:companies,id'],
            'translations'               => ['required', 'array'],
            'translations.*.title'       => ['required', 'string', 'max:255'],
            'translations.*.sub_title'   => ['nullable', 'string', 'max:255'],
            'translations.*.content'     => ['nullable', 'string'],
            'translations.*.challenges'    => ['nullable', 'string'],
            'translations.*.solutions'     => ['nullable', 'string'],
            'main_media' => ['nullable', 'file', 'mimetypes:image/jpeg,image/png,image/webp,image/gif,video/mp4,video/webm,video/quicktime,video/x-msvideo'],
            'main_media_alt' => ['nullable', 'string', 'max:255'],
            'delete_main_media' => ['nullable', 'boolean'],
            'gallery_existing' => ['nullable', 'array'],
            'gallery_existing.*.id' => ['required_with:gallery_existing', 'integer', 'exists:media,id'],
            'gallery_existing.*.media_alt' => ['nullable', 'string', 'max:255'],
            'gallery_existing.*.order' => ['required', 'integer', 'min:1'],
            'gallery_existing.*.delete' => ['nullable', 'boolean'],
            'gallery_files' => ['nullable', 'array'],
            'gallery_files.*' => ['nullable', 'file', 'mimetypes:image/jpeg,image/png,image/webp,image/gif,video/mp4,video/webm,video/quicktime,video/x-msvideo'],
            'gallery_files_meta' => ['nullable', 'array'],
            'gallery_files_meta.*.media_alt' => ['nullable', 'string', 'max:255'],
            'gallery_files_meta.*.order' => ['required_with:gallery_files.*', 'integer', 'min:1'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $kpis = $this->input('kpis');

        if ($this->filled('kpis_json')) {
            $decoded = json_decode($this->input('kpis_json'), true);

            if (is_array($decoded)) {
                $kpis = $decoded;
            }
        }

        $this->merge([
            'is_active' => (bool) $this->boolean('is_active'),
            'order'     => $this->input('order') === null ? 0 : (int) $this->input('order'),
            'kpis'      => is_array($kpis) ? $kpis : [],
        ]);
    }
}
