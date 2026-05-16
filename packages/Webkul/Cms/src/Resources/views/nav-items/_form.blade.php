@php
    $resolveItemLabel = function ($item) {
        $en = $item->translations?->firstWhere('locale', 'en');
        if ($en?->label) {
            return $en->label;
        }

        $page = $item->page;
        if ($page) {
            $pt = $page->translations?->firstWhere('locale', 'en');

            return $pt?->title ?? $page->name;
        }

        return '#'.$item->id;
    };
@endphp

<div class="flex flex-col gap-2.5 max-xl:flex-wrap">
    <input type="hidden" name="menu_id" value="{{ $navMenu->id }}" />

    <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
        <div class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
            <div class="mb-4">
                <p class="text-base font-semibold text-gray-800 dark:text-white">
                    @lang('cms::app.nav-items.form.general')
                </p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    @lang('cms::app.nav-items.form.general-hint')
                </p>
            </div>

            <div class="flex flex-col gap-4">
                <x-admin::form.control-group>
                    <x-admin::form.control-group.label>
                        @lang('cms::app.nav-items.form.parent')
                    </x-admin::form.control-group.label>

                    <x-admin::form.control-group.control
                        type="select"
                        id="parent_id"
                        name="parent_id"
                        :value="old('parent_id') ?? ($navItem?->parent_id ?? '')"
                        :label="trans('cms::app.nav-items.form.parent')"
                    >
                        <option value="">@lang('cms::app.nav-items.form.parent_none')</option>
                        @foreach($parentOptions as $parent)
                            <option value="{{ $parent->id }}">{{ $resolveItemLabel($parent) }}</option>
                        @endforeach
                    </x-admin::form.control-group.control>

                    <x-admin::form.control-group.error control-name="parent_id" />
                </x-admin::form.control-group>

                <div class="grid grid-cols-2 gap-4">
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('cms::app.nav-items.form.page')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="select"
                            id="cms_page_id"
                            name="cms_page_id"
                            :value="old('cms_page_id') ?? ($navItem?->cms_page_id ?? '')"
                            :label="trans('cms::app.nav-items.form.page')"
                        >
                            <option value="">@lang('cms::app.nav-items.form.page_none')</option>
                            @foreach($pages as $page)
                                @php($pt = $page->translations?->firstWhere('locale', 'en'))
                                <option value="{{ $page->id }}">
                                    {{ $pt?->title ?? $page->name }} ({{ $page->slug }})
                                </option>
                            @endforeach
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="cms_page_id" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('cms::app.nav-items.form.url')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            id="url"
                            name="url"
                            :value="old('url') ?? ($navItem?->url ?? '')"
                            :label="trans('cms::app.nav-items.form.url')"
                            :placeholder="trans('cms::app.nav-items.form.url_placeholder')"
                        />

                        <x-admin::form.control-group.error control-name="url" />
                    </x-admin::form.control-group>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('cms::app.nav-items.form.order')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="number"
                            id="order"
                            name="order"
                            min="0"
                            :value="old('order') ?? ($navItem?->order ?? 0)"
                            :label="trans('cms::app.nav-items.form.order')"
                        />

                        <x-admin::form.control-group.error control-name="order" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="!mb-0">
                        <x-admin::form.control-group.label>
                            @lang('cms::app.nav-items.form.active')
                        </x-admin::form.control-group.label>

                        <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
                                @checked(old('is_active', $navItem?->is_active ?? true))
                            />
                            <span>@lang('cms::app.nav-items.form.active')</span>
                        </label>

                        <x-admin::form.control-group.error control-name="is_active" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="!mb-0">
                        <x-admin::form.control-group.label>
                            @lang('cms::app.nav-items.form.open_in_new_tab')
                        </x-admin::form.control-group.label>

                        <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                            <input
                                type="checkbox"
                                name="open_in_new_tab"
                                value="1"
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
                                @checked(old('open_in_new_tab', $navItem?->open_in_new_tab ?? false))
                            />
                            <span>@lang('cms::app.nav-items.form.open_in_new_tab')</span>
                        </label>

                        <x-admin::form.control-group.error control-name="open_in_new_tab" />
                    </x-admin::form.control-group>
                </div>
            </div>
        </div>
    </div>

    <div class="flex w-full flex-col gap-2">
        <x-admin::accordion>
            <x-slot:header>
                <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                    @lang('cms::app.nav-items.form.translations')
                </p>
            </x-slot>

            <x-slot:content>
                @php($tabId = 'cms-nav-item-translations')
                @php($firstLocale = array_key_first($locales))

                <p class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                    @lang('cms::app.nav-items.form.translations-hint')
                </p>

                <div class="mb-4 flex flex-wrap gap-2">
                    @foreach($locales as $locale => $localeLabel)
                        <button
                            type="button"
                            class="cms-locale-tab rounded-md border border-gray-200 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-gray-950 {{ $locale === $firstLocale ? 'bg-gray-100 dark:bg-gray-950 text-gray-900 dark:text-white' : '' }}"
                            data-tab-group="{{ $tabId }}"
                            data-tab="{{ $locale }}"
                        >
                            {{ $localeLabel }} ({{ $locale }})
                        </button>
                    @endforeach
                </div>

                @foreach($locales as $locale => $localeLabel)
                    @php($row = $navItem?->translations?->firstWhere('locale', $locale))
                    <div
                        class="cms-locale-panel {{ $locale === $firstLocale ? '' : 'hidden' }}"
                        data-tab-group="{{ $tabId }}"
                        data-tab-panel="{{ $locale }}"
                    >
                        <x-admin::form.control-group class="!mb-0">
                            <x-admin::form.control-group.label>
                                @lang('cms::app.nav-items.form.label')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                id="translations_{{ $locale }}_label"
                                name="translations[{{ $locale }}][label]"
                                :value="old('translations.'.$locale.'.label') ?? ($row?->label ?? '')"
                                :label="trans('cms::app.nav-items.form.label')"
                            />

                            <x-admin::form.control-group.error control-name="translations.{{ $locale }}.label" />
                        </x-admin::form.control-group>
                    </div>
                @endforeach
            </x-slot>
        </x-admin::accordion>
    </div>
</div>

@pushOnce('scripts')
    <script type="module">
        (() => {
            const setActive = (group, tab) => {
                document.querySelectorAll(`.cms-locale-tab[data-tab-group="${group}"]`).forEach((btn) => {
                    const isActive = btn.getAttribute('data-tab') === tab;
                    btn.classList.toggle('bg-gray-100', isActive);
                    btn.classList.toggle('dark:bg-gray-950', isActive);
                    btn.classList.toggle('text-gray-900', isActive);
                    btn.classList.toggle('dark:text-white', isActive);
                });
                document.querySelectorAll(`.cms-locale-panel[data-tab-group="${group}"]`).forEach((panel) => {
                    panel.classList.toggle('hidden', panel.getAttribute('data-tab-panel') !== tab);
                });
            };

            document.addEventListener('click', (e) => {
                const btn = e.target.closest('.cms-locale-tab');
                if (! btn) return;
                setActive(btn.getAttribute('data-tab-group'), btn.getAttribute('data-tab'));
            });

            setActive(@json($tabId), @json($firstLocale));
        })();
    </script>
@endPushOnce
