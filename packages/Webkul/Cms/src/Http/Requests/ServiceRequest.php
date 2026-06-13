<?php

namespace Webkul\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cms_service_type_id' => ['nullable', 'integer', 'exists:cms_service_types,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:cms_services,slug,' . $this->route('id') . ',id,deleted_at,NULL'],
            'is_active'           => ['nullable', 'boolean'],
            'order'               => ['nullable', 'integer', 'min:0'],
            'company_id'          => ['nullable', 'integer', 'exists:companies,id'],
            'translations'        => ['required', 'array'],
            'translations.*.title'         => ['required', 'string', 'max:255'],
            'translations.*.sub_title'     => ['nullable', 'string', 'max:255'],
            'translations.*.problems'      => ['nullable', 'string'],
            'translations.*.solutions'     => ['nullable', 'string'],
            'translations.*.key_benefits'  => ['nullable', 'string'],
            'translations.*.deliverables'  => ['nullable', 'string'],
            'main_media' => ['nullable', 'file', 'mimetypes:image/jpeg,image/png,image/webp,image/gif,video/mp4,video/webm,video/quicktime,video/x-msvideo'],
            'main_media_alt' => ['nullable', 'string', 'max:255'],
            'delete_main_media' => ['nullable', 'boolean'],
            'icon_media' => ['nullable', 'file', 'mimetypes:image/jpeg,image/png,image/webp,image/gif,image/svg+xml'],
            'icon_media_alt' => ['nullable', 'string', 'max:255'],
            'delete_icon_media' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('name')),
            'is_active' => (bool) $this->boolean('is_active'),
            'order'     => $this->input('order') === null ? 0 : (int) $this->input('order'),
        ]);
    }
}
