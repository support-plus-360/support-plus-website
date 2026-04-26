<?php

namespace Webkul\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Webkul\Cms\Models\Item;
use Webkul\Cms\Models\Page;
use Webkul\Cms\Models\Section;

class LinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $linkableTypes = [
            Page::class,
            Section::class,
            Item::class,
        ];

        return [
            'linkable_type' => ['required', 'string', Rule::in($linkableTypes)],
            'linkable_id'   => [
                'required', 'integer',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $type = $this->input('linkable_type');
                    $table = match ($type) {
                        Page::class => 'cms_pages',
                        Section::class => 'cms_sections',
                        Item::class => 'cms_items',
                        default => null,
                    };

                    if ($table === null) {
                        $fail(__('validation.in', ['attribute' => $attribute]));

                        return;
                    }

                    if (! DB::table($table)->where('id', $value)->exists()) {
                        $fail(__('validation.exists', ['attribute' => $attribute]));
                    }
                },
            ],
            'link'      => ['required', 'string', 'max:2048'],
            'icon'      => ['nullable', 'string', 'max:255'],
            'target'    => ['nullable', 'string', Rule::in(['_self', '_blank', '_parent', '_top'])],
            'type'      => ['nullable', 'string', Rule::in(['social', 'contact', 'quick', 'custom'])],
            'is_active' => ['nullable', 'boolean'],
            'order'     => ['nullable', 'integer', 'min:0'],
            'company_id' => ['nullable', 'integer', 'exists:companies,id'],

            'translations' => ['required', 'array'],
            'translations.*.name'   => ['required', 'string', 'max:255'],
            'translations.*.locale' => ['required', 'string', 'in:en,ar'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => (bool) $this->boolean('is_active'),
            'order'     => $this->input('order') === null || $this->input('order') === '' ? 0 : (int) $this->input('order'),
            'target'    => $this->filled('target') ? $this->input('target') : '_self',
        ]);
    }
}
