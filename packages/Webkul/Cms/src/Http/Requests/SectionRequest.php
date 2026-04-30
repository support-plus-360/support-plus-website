<?php

namespace Webkul\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $sectionId = $this->route('id');

        return [
            'name'         => [
                'required',
                'string',
                'max:255',
                Rule::unique('cms_sections', 'name')->ignore($sectionId),
            ],
            'page_id'      => ['required', 'exists:cms_pages,id'],
            'type'         => ['required', 'string', Rule::in(['default', 'hero', 'gallery', 'testimonial', 'industry'])],
            'is_active'    => ['nullable', 'boolean'],
            'order'        => ['nullable', 'integer', 'min:0'],
            'template'     => ['nullable', 'string', 'max:255'],
            'settings'     => ['nullable', 'array'],
            'company_id'   => ['nullable', 'integer', 'exists:companies,id'],
            'translations' => ['required', 'array'],
            'translations.*.title' => ['required', 'string', 'max:255'],
            'translations.*.subtitle' => ['nullable', 'string'],
            'translations.*.description' => ['nullable', 'string'],
            'main_media' => ['nullable', 'file', 'mimetypes:image/jpeg,image/png,image/webp,image/gif,video/mp4,video/webm,video/quicktime,video/x-msvideo'],
            'main_media_alt' => ['nullable', 'string', 'max:255'],
            'delete_main_media' => ['nullable', 'boolean'],
            'gallery_existing' => ['nullable', 'array'],
            'gallery_existing.*.id' => ['required_with:gallery_existing', 'integer', 'exists:media,id'],
            'gallery_existing.*.media_alt' => ['nullable', 'string', 'max:255'],
            'gallery_existing.*.order' => ['required', 'integer', 'min:1'],
            'gallery_existing.*.delete' => ['nullable', 'boolean'],
            'gallery_new' => ['nullable', 'array'],
            'gallery_new.*.file' => ['nullable', 'file', 'mimetypes:image/jpeg,image/png,image/webp,image/gif,video/mp4,video/webm,video/quicktime,video/x-msvideo'],
            'gallery_new.*.media_alt' => ['nullable', 'string', 'max:255'],
            'gallery_new.*.order' => ['required', 'integer', 'min:1'],
            'gallery_files' => ['nullable', 'array'],
            'gallery_files.*' => ['nullable', 'file', 'mimetypes:image/jpeg,image/png,image/webp,image/gif,video/mp4,video/webm,video/quicktime,video/x-msvideo'],
            'gallery_files_meta' => ['nullable', 'array'],
            'gallery_files_meta.*.media_alt' => ['nullable', 'string', 'max:255'],
            'gallery_files_meta.*.order' => ['required_with:gallery_files.*', 'integer', 'min:1'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $settings = $this->input('settings');

        if (is_string($settings)) {
            $decoded = json_decode($settings, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $this->merge(['settings' => $decoded]);
            }
        }

        $this->merge([
            'is_active' => (bool) $this->boolean('is_active'),
            'order'     => $this->input('order') === null ? 0 : (int) $this->input('order'),
        ]);
    }
}

