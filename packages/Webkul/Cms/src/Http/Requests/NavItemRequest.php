<?php

namespace Webkul\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Webkul\Cms\Models\NavItem;

class NavItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $itemId = $this->route('id');
        $menuId = (int) ($this->input('menu_id') ?? $this->route('menuId'));

        return [
            'menu_id'          => ['required', 'integer', 'exists:cms_nav_menus,id'],
            'parent_id'        => [
                'nullable',
                'integer',
                Rule::exists('cms_nav_items', 'id')->where(fn ($q) => $q->where('menu_id', $menuId)),
                Rule::notIn(array_filter([(int) $itemId])),
            ],
            'cms_page_id'      => ['nullable', 'integer', 'exists:cms_pages,id'],
            'url'              => ['nullable', 'string', 'max:2048'],
            'order'            => ['nullable', 'integer', 'min:0'],
            'is_active'        => ['nullable', 'boolean'],
            'open_in_new_tab'  => ['nullable', 'boolean'],
            'translations'                       => ['nullable', 'array'],
            'translations.*.label'               => ['nullable', 'string', 'max:255'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $parentId = $this->input('parent_id');
            $itemId = $this->route('id');

            if ($parentId && $itemId && $this->wouldCreateCycle((int) $itemId, (int) $parentId)) {
                $validator->errors()->add('parent_id', trans('cms::app.nav-items.validation.parent-cycle'));
            }
        });
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'       => (bool) $this->boolean('is_active'),
            'open_in_new_tab' => (bool) $this->boolean('open_in_new_tab'),
            'order'           => $this->input('order') === null ? 0 : (int) $this->input('order'),
            'menu_id'         => $this->input('menu_id') ?? $this->route('menuId'),
        ]);
    }

    protected function wouldCreateCycle(int $itemId, int $parentId): bool
    {
        $current = $parentId;

        while ($current) {
            if ($current === $itemId) {
                return true;
            }

            $current = NavItem::query()->whereKey($current)->value('parent_id');
        }

        return false;
    }
}
