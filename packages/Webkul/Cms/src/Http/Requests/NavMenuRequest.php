<?php

namespace Webkul\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NavMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $menuId = $this->route('id') ?? $this->route('menuId');

        return [
            'company_id' => ['nullable', 'integer', 'exists:companies,id'],
            'key'        => [
                'required',
                'string',
                Rule::in(['header', 'footer']),
                Rule::unique('cms_nav_menus', 'key')
                    ->where(fn ($q) => $q->where('company_id', $this->input('company_id')))
                    ->ignore($menuId),
            ],
            'name' => ['required', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('key')) {
            $this->merge(['key' => strtolower(trim((string) $this->input('key')))]);
        }
    }
}
