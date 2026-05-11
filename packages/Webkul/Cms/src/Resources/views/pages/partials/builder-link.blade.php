@php
    $linkTypes = [
        'social' => __('cms::app.links.form.link_type_social'),
        'contact' => __('cms::app.links.form.link_type_contact'),
        'quick' => __('cms::app.links.form.link_type_quick'),
        'custom' => __('cms::app.links.form.link_type_custom'),
    ];
    $targets = [
        '_self' => __('cms::app.links.form.target_self'),
        '_blank' => __('cms::app.links.form.target_blank'),
    ];
    $locales = $locales ?? ['en' => 'English', 'ar' => 'Arabic'];
    $firstLocale = array_key_first($locales);
    $showRemove = $showRemove ?? false;
@endphp

<div class="cms-builder-link-block mb-4 rounded-lg border border-gray-200 p-3 dark:border-gray-800" data-cms-builder-link>
    <input type="hidden" name="{{ $namePrefix }}[id]" value="{{ old($oldPrefix.'.id', $link?->id) }}" />

    @if ($showRemove)
        <div class="mb-3 flex flex-wrap items-center justify-between gap-2">
            <p class="text-sm font-semibold text-gray-800 dark:text-white">
                @lang('cms::app.menu.links')
            </p>
            <button
                type="button"
                class="cms-builder-remove-btn shrink-0"
                data-cms-remove-link
                aria-label="@lang('cms::app.pages.builder.remove-link')"
            >
                @lang('cms::app.pages.builder.remove-link')
            </button>
        </div>
    @endif

    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
        @lang('cms::app.pages.form.translations')
    </p>
    <div class="mb-3 flex flex-wrap gap-2">
        @foreach ($locales as $locale => $localeLabel)
            <button
                type="button"
                class="cms-locale-tab rounded-md border border-gray-200 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-gray-950 {{ $locale === $firstLocale ? 'bg-gray-100 dark:bg-gray-950 text-gray-900 dark:text-white' : '' }}"
                data-tab-group="{{ $tabGroupId }}"
                data-tab="{{ $locale }}"
            >
                {{ $localeLabel }} ({{ $locale }})
            </button>
        @endforeach
    </div>

    @foreach ($locales as $locale => $localeLabel)
        <div
            class="cms-locale-panel {{ $locale === $firstLocale ? '' : 'hidden' }}"
            data-tab-group="{{ $tabGroupId }}"
            data-tab-panel="{{ $locale }}"
        >
            <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-300">
                @lang('cms::app.links.form.name')
            </label>
            <input
                type="text"
                name="{{ $namePrefix }}[translations][{{ $locale }}][name]"
                value="{{ old($oldPrefix.'.translations.'.$locale.'.name', $link?->translate($locale, false)?->name) }}"
                class="w-full rounded border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900"
                @if ($locale === 'en') required @endif
            />
        </div>
    @endforeach

    <div class="mt-4 border-t border-gray-100 pt-4 dark:border-gray-800">
        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
            @lang('cms::app.links.form.general')
        </p>
        <div class="grid gap-3 md:grid-cols-2">
            <div>
                <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-300">URL</label>
                <input
                    type="text"
                    name="{{ $namePrefix }}[link]"
                    value="{{ old($oldPrefix.'.link', $link?->link) }}"
                    class="w-full rounded border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900"
                    required
                />
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-300">@lang('cms::app.links.form.target')</label>
                    <select name="{{ $namePrefix }}[target]" class="w-full rounded border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900">
                        @foreach ($targets as $val => $label)
                            <option value="{{ $val }}" @selected(old($oldPrefix.'.target', $link?->target ?? '_self') === $val)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-300">@lang('cms::app.links.form.type')</label>
                    <select name="{{ $namePrefix }}[type]" class="w-full rounded border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900">
                        <option value="">—</option>
                        @foreach ($linkTypes as $val => $label)
                            <option value="{{ $val }}" @selected(old($oldPrefix.'.type', $link?->type) === $val)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-3 grid gap-3 md:grid-cols-3">
            <div>
                <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-300">@lang('cms::app.links.form.icon')</label>
                <input
                    type="text"
                    name="{{ $namePrefix }}[icon]"
                    value="{{ old($oldPrefix.'.icon', $link?->icon) }}"
                    class="w-full rounded border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900"
                />
            </div>
            <div>
                <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-300">@lang('cms::app.pages.form.order')</label>
                <input
                    type="number"
                    name="{{ $namePrefix }}[order]"
                    value="{{ old($oldPrefix.'.order', $link?->order ?? 0) }}"
                    class="w-full rounded border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900"
                />
            </div>
            <div class="flex items-end gap-2 pb-1">
                <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                    <input
                        type="checkbox"
                        name="{{ $namePrefix }}[is_active]"
                        value="1"
                        class="h-4 w-4 rounded border-gray-300"
                        @checked(old($oldPrefix.'.is_active', $link?->is_active ?? true))
                    />
                    @lang('cms::app.pages.form.active')
                </label>
            </div>
        </div>
    </div>
</div>
